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
            'email' => 'required|string|email|max:255|unique:members,email_index',
            'password' => 'required|string|min:8|confirmed',
            // 基本プロフィール
            'phone' => 'nullable|string|max:20',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:500',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'capital' => 'nullable|integer|min:0',
            'industry' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:50',
            'concerns' => 'nullable|string',
            'notes' => 'nullable|string',
            'membership_type' => 'required|in:free,basic,standard,premium',
            'status' => 'required|in:pending,active,suspended,cancelled',
            'membership_expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            \Log::error('Member creation validation failed', [
                'errors' => $validator->errors(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'バリデーションエラー',
                'errors' => $validator->errors(),
                'debug' => [
                    'received_fields' => array_keys($request->all()),
                    'validation_rules' => [
                        'company_name' => 'required|string|max:255',
                        'representative_name' => 'required|string|max:100',
                        'email' => 'required|string|email|max:255|unique:members',
                        'password' => 'required|string|min:8|confirmed',
                    ]
                ]
            ], 422);
        }

        $member = Member::create([
            'company_name' => $request->company_name,
            'representative_name' => $request->representative_name,
            'email' => $request->email,
            'email_index' => mb_strtolower(trim($request->email)),
            // Hashing is handled by Member model mutator
            'password' => $request->password,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'position' => $request->position,
            'department' => $request->department,
            'capital' => $request->capital,
            'industry' => $request->industry,
            'region' => $request->region,
            'concerns' => $request->concerns,
            'notes' => $request->notes,
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
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'capital' => 'nullable|integer|min:0',
            'industry' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:50',
            'concerns' => 'nullable|string',
            'notes' => 'nullable|string',
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
            'postal_code',
            'address',
            'position',
            'department',
            'capital',
            'industry',
            'region',
            'concerns',
            'notes',
            'membership_type',
            'status',
            'membership_expires_at',
            'is_active',
            'joined_date',
            'expiry_date'
        ]);

        if ($request->filled('email')) {
            $updateData['email_index'] = mb_strtolower(trim($request->email));
        }

        if ($request->password) {
            // Hashing is handled by Member model mutator
            $updateData['password'] = $request->password;
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

    /**
     * 会員をCSVで一括エクスポート（管理者用）
     * フィルタは index と同等のパラメータをサポート
     */
    public function exportCsv(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('representative_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%");
            });
        }
        if ($request->filled('membership_type')) {
            $query->where('membership_type', $request->membership_type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $rows = $query->get([
            'id', 'company_name', 'representative_name', 'email', 'phone', 'postal_code', 'address',
            'position', 'department', 'industry', 'region', 'capital', 'concerns', 'notes',
            'membership_type', 'status', 'is_active', 'joined_date', 'membership_expires_at', 'created_at'
        ]);

        $csv = "ID,会社名,代表者名,メールアドレス,電話番号,郵便番号,住所,役職,部署,業種,地域,資本金,お困りごと,備考,会員種別,状態,アクティブ,入会日,会員期限,登録日\n";

        foreach ($rows as $r) {
            $formatDate = function ($value, $format = 'Y-m-d H:i:s') {
                try {
                    if ($value instanceof \Carbon\CarbonInterface) {
                        return $value->timezone('Asia/Tokyo')->format($format);
                    }
                    if ($value instanceof \DateTimeInterface) {
                        return \Carbon\Carbon::instance($value)->timezone('Asia/Tokyo')->format($format);
                    }
                    if (is_string($value) && $value !== '') {
                        return \Carbon\Carbon::parse($value)->timezone('Asia/Tokyo')->format($format);
                    }
                } catch (\Throwable $e) {
                    // フォーマットに失敗した場合は元の値（文字列）を返す
                    return is_scalar($value) ? (string)$value : '';
                }
                return '';
            };

            $line = [
                $r->id,
                $r->company_name,
                $r->representative_name,
                $r->email,
                $r->phone,
                $r->postal_code,
                $r->address,
                $r->position,
                $r->department,
                $r->industry,
                $r->region,
                is_null($r->capital) ? '' : (string)$r->capital,
                $r->concerns,
                $r->notes,
                $r->membership_type,
                $r->status,
                $r->is_active ? 'TRUE' : 'FALSE',
                $formatDate($r->joined_date, 'Y-m-d'),
                $formatDate($r->membership_expires_at, 'Y-m-d H:i:s'),
                $formatDate($r->created_at, 'Y-m-d H:i:s'),
            ];
            $csv .= implode(',', array_map(function($v){
                $v = (string)($v ?? '');
                $v = str_replace(["\r","\n"], ' ', $v);
                if (strpos($v, ',') !== false || strpos($v, '"') !== false) {
                    $v = '"' . str_replace('"', '""', $v) . '"';
                }
                return $v;
            }, $line)) . "\n";
        }

        $filename = 'members_' . now()->format('Ymd_His') . '.csv';
        $bom = "\xEF\xBB\xBF"; // UTF-8 BOM for Excel
        return response($bom . $csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * パスワードを自動生成してリセット（管理者用）
     */
    public function resetPassword(Request $request, $id): JsonResponse
    {
        $request->validate([
            'length' => 'nullable|integer|min:8|max:64',
            'send_mail' => 'nullable|boolean',
        ]);

        $member = Member::findOrFail($id);
        $length = (int)($request->length ?? 12);

        // 生成ポリシー: 英大小/数字（記号は省く）
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
        $pwd = '';
        for ($i=0; $i<$length; $i++) {
            $pwd .= $chars[random_int(0, strlen($chars)-1)];
        }

        $member->password = $pwd; // mutator でハッシュ化
        $member->save();

        // ここで通知メール送信を行いたい場合は Notification 実装を追加
        // if ($request->boolean('send_mail')) { ... }

        return response()->json([
            'success' => true,
            'message' => 'パスワードをリセットしました',
            'generated_password' => $pwd,
            'member_id' => $member->id,
        ]);
    }
}
