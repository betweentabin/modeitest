<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberProfileController extends Controller
{
    /**
     * 会員プロフィール情報を取得
     */
    public function show(Request $request)
    {
        try {
            $member = Auth::guard('sanctum')->user();
            
            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => '認証が必要です'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $member->id,
                    'email' => $member->email,
                    'company_name' => $member->company_name,
                    'representative_name' => $member->representative_name,
                    'phone' => $member->phone,
                    'postal_code' => $member->postal_code,
                    'address' => $member->address,
                    'membership_type' => $member->membership_type,
                    'status' => $member->status,
                    'joined_date' => $member->joined_date,
                    'membership_expires_at' => $member->membership_expires_at,
                    'is_active' => $member->is_active,
                    'created_at' => $member->created_at,
                    'updated_at' => $member->updated_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'プロフィール情報の取得に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 会員プロフィール情報を更新
     */
    public function update(Request $request)
    {
        try {
            $member = Auth::guard('sanctum')->user();
            
            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => '認証が必要です'
                ], 401);
            }

            // バリデーション
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'representative_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'postal_code' => 'nullable|string|max:10',
                'address' => 'nullable|string|max:500',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('members')->ignore($member->id),
                ],
            ], [
                'company_name.required' => '会社名は必須です',
                'representative_name.required' => '代表者名は必須です',
                'email.required' => 'メールアドレスは必須です',
                'email.email' => 'メールアドレスの形式が正しくありません',
                'email.unique' => 'このメールアドレスは既に使用されています',
            ]);

            // プロフィール更新
            $member->update($validated);

            // 更新後のデータを返却
            $member->refresh();

            return response()->json([
                'success' => true,
                'message' => 'プロフィールを更新しました',
                'data' => [
                    'id' => $member->id,
                    'email' => $member->email,
                    'company_name' => $member->company_name,
                    'representative_name' => $member->representative_name,
                    'phone' => $member->phone,
                    'postal_code' => $member->postal_code,
                    'address' => $member->address,
                    'membership_type' => $member->membership_type,
                    'status' => $member->status,
                    'updated_at' => $member->updated_at,
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'バリデーションエラーがあります',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'プロフィールの更新に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * パスワード変更
     */
    public function updatePassword(Request $request)
    {
        try {
            $member = Auth::guard('sanctum')->user();
            
            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => '認証が必要です'
                ], 401);
            }

            // バリデーション
            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed',
            ], [
                'current_password.required' => '現在のパスワードは必須です',
                'new_password.required' => '新しいパスワードは必須です',
                'new_password.min' => 'パスワードは8文字以上で入力してください',
                'new_password.confirmed' => 'パスワード確認が一致しません',
            ]);

            // 現在のパスワードが正しいかチェック
            if (!Hash::check($validated['current_password'], $member->password)) {
                return response()->json([
                    'success' => false,
                    'message' => '現在のパスワードが正しくありません'
                ], 400);
            }

            // パスワード更新
            $member->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'パスワードを変更しました'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'バリデーションエラーがあります',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'パスワードの変更に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * アカウント削除（論理削除）
     */
    public function deleteAccount(Request $request)
    {
        try {
            $member = Auth::guard('sanctum')->user();
            
            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => '認証が必要です'
                ], 401);
            }

            // バリデーション
            $validated = $request->validate([
                'password' => 'required|string',
                'confirmation' => 'required|string|in:DELETE',
            ], [
                'password.required' => 'パスワードは必須です',
                'confirmation.required' => '削除確認文字列は必須です',
                'confirmation.in' => '削除確認には "DELETE" と入力してください',
            ]);

            // パスワードが正しいかチェック
            if (!Hash::check($validated['password'], $member->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'パスワードが正しくありません'
                ], 400);
            }

            // アカウントを無効化（論理削除）
            $member->update([
                'status' => 'cancelled',
                'is_active' => false,
            ]);

            // 全トークンを削除（ログアウト）
            $member->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'アカウントを削除しました'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'バリデーションエラーがあります',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'アカウントの削除に失敗しました',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
