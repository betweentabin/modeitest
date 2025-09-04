<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * 会員一覧を取得
     */
    public function index(Request $request): JsonResponse
    {
        $query = Member::query();

        // 検索フィルター
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('representative_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%");
            });
        }

        // 会員種別フィルター
        if ($request->has('membership_type') && $request->membership_type) {
            $query->where('membership_type', $request->membership_type);
        }

        // ステータスフィルター
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // アクティブフィルター
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // ソート
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // ページネーション
        $perPage = $request->get('per_page', 15);
        $members = $query->paginate($perPage);

        // 各会員の追加情報を含める
        $members->getCollection()->transform(function ($member) {
            $member->is_expiring_soon = $member->isExpiringSoon();
            $member->membership_level_value = $member->getMembershipLevelValue();
            return $member;
        });

        return response()->json($members);
    }

    /**
     * 会員詳細を取得
     */
    public function show($id): JsonResponse
    {
        $member = Member::findOrFail($id);
        $member->is_expiring_soon = $member->isExpiringSoon();
        $member->membership_level_value = $member->getMembershipLevelValue();
        return response()->json($member);
    }

    /**
     * 新規会員を作成
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'representative_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'membership_type' => 'required|in:free,basic,standard,premium',
            'status' => 'required|in:pending,active,suspended,cancelled',
            'membership_expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = Member::create([
            'company_name' => $request->company_name,
            'representative_name' => $request->representative_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'membership_type' => $request->membership_type,
            'status' => $request->status ?? 'active',
            'membership_expires_at' => $request->membership_expires_at,
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => '会員を作成しました',
            'data' => $member
        ], 201);
    }

        /**
     * 会員情報を更新（管理者用）
     */
    public function update(Request $request, $id): JsonResponse
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'representative_name' => 'sometimes|string|max:100',
            'email' => 'sometimes|string|email|max:255|unique:members,email,' . $id,
            'password' => 'nullable|string|min:8',
            'company_name' => 'sometimes|string|max:200',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'membership_type' => 'sometimes|in:free,basic,standard,premium',
            'status' => 'sometimes|in:pending,active,suspended,cancelled',
            'membership_expires_at' => 'nullable|date_format:Y-m-d H:i:s',
            'is_active' => 'sometimes|boolean',
            'joined_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only([
            'representative_name',
            'email',
            'company_name',
            'phone',
            'address',
            'membership_type',
            'status',
            'membership_expires_at',
            'is_active',
            'joined_date',
            'expiry_date'
        ]);

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $member->update($updateData);

        // 更新後の情報を取得
        $member->refresh();
        $member->is_expiring_soon = $member->isExpiringSoon();
        $member->membership_level_value = $member->getMembershipLevelValue();

        return response()->json([
            'message' => '会員情報を更新しました',
            'member' => $member
        ]);
    }

    /**
     * 会員を削除
     */
    public function destroy($id): JsonResponse
    {
        $member = User::findOrFail($id);
        $member->delete();

        return response()->json([
            'message' => '会員を削除しました'
        ]);
    }

    /**
     * 会員統計を取得
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_members' => User::count(),
            'active_members' => User::where('status', 'active')->count(),
            'standard_members' => User::where('membership_type', 'standard')->count(),
            'premium_members' => User::where('membership_type', 'premium')->count(),
            'inactive_members' => User::where('status', 'inactive')->count(),
            'suspended_members' => User::where('status', 'suspended')->count(),
            'recent_registrations' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return response()->json($stats);
    }

    /**
     * 会員ステータスを更新
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,active,suspended,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = Member::findOrFail($id);
        $member->update(['status' => $request->status]);

        return response()->json([
            'message' => '会員ステータスを更新しました',
            'member' => $member
        ]);
    }

    /**
     * 会員のランクを更新
     */
    public function updateMembership(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'membership_type' => 'required|in:free,basic,standard,premium',
            'membership_expires_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = Member::findOrFail($id);
        
        $updateData = [
            'membership_type' => $request->membership_type,
            'membership_expires_at' => $request->membership_expires_at,
        ];

        if ($request->has('is_active')) {
            $updateData['is_active'] = $request->is_active;
        }

        $member->update($updateData);

        // 更新後の情報を取得
        $member->refresh();
        $member->is_expiring_soon = $member->isExpiringSoon();
        $member->membership_level_value = $member->getMembershipLevelValue();

        return response()->json([
            'message' => '会員ランクを更新しました',
            'member' => $member
        ]);
    }

    /**
     * 会員の有効期限を延長
     */
    public function extendMembership(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'extend_months' => 'required|integer|min:1|max:24',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = Member::findOrFail($id);
        
        // 現在の期限から延長、または現在日時から延長
        $currentExpiry = $member->membership_expires_at;
        $baseDate = $currentExpiry && $currentExpiry->isFuture() ? $currentExpiry : now();
        
        $newExpiry = $baseDate->addMonths($request->extend_months);
        
        $member->update([
            'membership_expires_at' => $newExpiry,
            'is_active' => true,
        ]);

        $member->refresh();
        $member->is_expiring_soon = $member->isExpiringSoon();

        return response()->json([
            'message' => "会員期限を{$request->extend_months}ヶ月延長しました",
            'member' => $member,
            'new_expiry' => $newExpiry->format('Y-m-d H:i:s')
        ]);
    }
}
