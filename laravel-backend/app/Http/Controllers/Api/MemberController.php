<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $query = User::query();

        // 検索フィルター
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('company', 'LIKE', "%{$search}%");
            });
        }

        // 会員種別フィルター
        if ($request->has('membership_type') && $request->membership_type) {
            $query->where('membership_type', $request->membership_type);
        }

        // ソート
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // ページネーション
        $perPage = $request->get('per_page', 15);
        $members = $query->paginate($perPage);

        return response()->json($members);
    }

    /**
     * 会員詳細を取得
     */
    public function show($id): JsonResponse
    {
        $member = User::findOrFail($id);
        return response()->json($member);
    }

    /**
     * 新規会員を作成
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'membership_type' => 'required|in:standard,premium',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company' => $request->company,
            'position' => $request->position,
            'phone' => $request->phone,
            'address' => $request->address,
            'membership_type' => $request->membership_type,
            'status' => $request->status ?? 'active',
            'email_verified_at' => now(),
        ]);

        return response()->json([
            'message' => '会員を作成しました',
            'member' => $member
        ], 201);
    }

    /**
     * 会員情報を更新
     */
    public function update(Request $request, $id): JsonResponse
    {
        $member = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'membership_type' => 'required|in:standard,premium',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'position' => $request->position,
            'phone' => $request->phone,
            'address' => $request->address,
            'membership_type' => $request->membership_type,
            'status' => $request->status,
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $member->update($updateData);

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
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors()
            ], 422);
        }

        $member = User::findOrFail($id);
        $member->update(['status' => $request->status]);

        return response()->json([
            'message' => '会員ステータスを更新しました',
            'member' => $member
        ]);
    }
}
