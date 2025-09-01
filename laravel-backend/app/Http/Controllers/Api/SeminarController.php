<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\SeminarRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeminarController extends Controller
{
    /**
     * セミナー一覧取得
     */
    public function index(Request $request)
    {
        $query = Seminar::query();

        // ステータスフィルタ
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // 会員要件フィルタ
        if ($request->has('membership_requirement')) {
            $query->where('membership_requirement', $request->membership_requirement);
        }

        // 日付範囲フィルタ
        if ($request->has('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        // 公開されているセミナーのみ（一般向け）
        // 管理者または認証済みユーザー以外には公開セミナーのみ表示
        if (!$request->user()) {
            $query->published();
        } elseif ($request->user() && !$request->user()->isAdmin()) {
            $query->published();
        }
        // 管理者の場合は全てのステータスのセミナーを表示

        // ソート
        $query->orderBy('date', 'asc')->orderBy('start_time', 'asc');

        // ページネーション
        $perPage = $request->input('per_page', 10);
        $seminars = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => [
                'seminars' => $seminars->items(),
                'pagination' => [
                    'current_page' => $seminars->currentPage(),
                    'total_pages' => $seminars->lastPage(),
                    'total_items' => $seminars->total(),
                    'per_page' => $seminars->perPage(),
                ]
            ]
        ]);
    }

    /**
     * セミナー詳細取得
     */
    public function show($id)
    {
        $seminar = Seminar::with(['creator', 'registrations'])->findOrFail($id);

        // 非公開セミナーは管理者のみ
        if ($seminar->status === 'draft' && 
            (!auth()->user() || !auth()->user()->isAdmin())) {
            abort(404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'seminar' => $seminar,
                'can_register' => $seminar->can_register,
                'available_spots' => $seminar->available_spots,
                'formatted_date' => $seminar->formatted_date,
                'formatted_time' => $seminar->formatted_time,
                'formatted_fee' => $seminar->formatted_fee,
            ]
        ]);
    }

    /**
     * セミナー作成（管理者のみ）
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:200',
            'capacity' => 'nullable|integer|min:0',
            'fee' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,scheduled,ongoing,completed,cancelled',
            'membership_requirement' => 'nullable|in:none,basic,standard,premium',
            'featured_image' => 'nullable|string|max:500',
            'application_deadline' => 'nullable|date|before_or_equal:date',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => '入力データに誤りがあります',
                    'details' => $validator->errors()
                ]
            ], 422);
        }

        $seminar = Seminar::create(array_merge($validator->validated(), [
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'status' => $request->input('status', 'scheduled'), // デフォルトをscheduledに変更
        ]));

        return response()->json([
            'success' => true,
            'data' => ['seminar' => $seminar],
            'message' => 'セミナーが正常に作成されました'
        ], 201);
    }

    /**
     * セミナー更新（管理者のみ）
     */
    public function update(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:200',
            'description' => 'nullable|string',
            'detailed_description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:200',
            'capacity' => 'nullable|integer|min:0',
            'fee' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,scheduled,ongoing,completed,cancelled',
            'membership_requirement' => 'nullable|in:none,basic,standard,premium',
            'featured_image' => 'nullable|string|max:500',
            'application_deadline' => 'nullable|date',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => '入力データに誤りがあります',
                    'details' => $validator->errors()
                ]
            ], 422);
        }

        $seminar->update(array_merge($validator->validated(), [
            'updated_by' => auth()->id(),
        ]));

        return response()->json([
            'success' => true,
            'data' => ['seminar' => $seminar],
            'message' => 'セミナーが正常に更新されました'
        ]);
    }

    /**
     * セミナー削除（管理者のみ）
     */
    public function destroy($id)
    {
        $seminar = Seminar::findOrFail($id);
        
        // 申込者がいる場合は削除不可
        if ($seminar->registrations()->count() > 0) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'CANNOT_DELETE',
                    'message' => '申込者がいるため削除できません'
                ]
            ], 400);
        }

        $seminar->delete();

        return response()->json([
            'success' => true,
            'message' => 'セミナーが正常に削除されました'
        ]);
    }

    /**
     * セミナー申込
     */
    public function register(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        // 申込可能性チェック
        if (!$seminar->can_register) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'REGISTRATION_CLOSED',
                    'message' => 'このセミナーは申込を受け付けていません'
                ]
            ], 400);
        }

        // 会員の場合の権限チェック
        $member = auth('member')->user();
        if ($member && !$member->canRegisterSeminar($seminar)) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'INSUFFICIENT_MEMBERSHIP',
                    'message' => '申込に必要な会員レベルに達していません'
                ]
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:200',
            'phone' => 'nullable|string|max:20',
            'special_requests' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => '入力データに誤りがあります',
                    'details' => $validator->errors()
                ]
            ], 422);
        }

        // 重複申込チェック
        $existingRegistration = SeminarRegistration::where('seminar_id', $seminar->id)
            ->where('email', $request->email)
            ->where('attendance_status', '!=', 'cancelled')
            ->first();

        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'ALREADY_REGISTERED',
                    'message' => '既にこのセミナーに申込済みです'
                ]
            ], 400);
        }

        // 定員チェック（再確認）
        if ($seminar->is_full) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'CAPACITY_EXCEEDED',
                    'message' => '定員に達しているため申込できません'
                ]
            ], 400);
        }

        $registration = SeminarRegistration::create(array_merge($validator->validated(), [
            'seminar_id' => $seminar->id,
            'member_id' => $member ? $member->id : null,
            'registration_number' => $this->generateRegistrationNumber(),
            'attendance_status' => 'registered',
            'payment_status' => $seminar->fee > 0 ? 'pending' : 'paid',
        ]));

        // 参加者数更新
        $seminar->updateParticipantCount();

        return response()->json([
            'success' => true,
            'data' => [
                'registration' => $registration,
                'registration_number' => $registration->registration_number,
            ],
            'message' => 'セミナーに正常に申込されました'
        ], 201);
    }

    /**
     * 申込番号生成
     */
    private function generateRegistrationNumber()
    {
        do {
            $number = 'SEM' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (SeminarRegistration::where('registration_number', $number)->exists());

        return $number;
    }
}