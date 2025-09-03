<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberFavorite;
use App\Models\Publication;
use App\Models\Seminar;
use Illuminate\Http\Request;

class MemberDashboardController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->user();

        // 安全策
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $memberType = $member->membership_type ?? 'free';

        // お気に入り情報
        $favoritesQuery = MemberFavorite::where('member_id', $member->id)
            ->orderBy('created_at', 'desc');
        $favoritesCount = (clone $favoritesQuery)->count();
        $recentFavorites = $favoritesQuery->take(5)
            ->with(['favoriteMember:id,company_name,representative_name,email,phone,address,membership_type'])
            ->get()
            ->map(function ($fav) {
                return [
                    'id' => $fav->favorite_member_id,
                    'company_name' => $fav->favoriteMember->company_name ?? '',
                    'representative_name' => $fav->favoriteMember->representative_name ?? '',
                    'email' => $fav->favoriteMember->email ?? null,
                    'phone' => $fav->favoriteMember->phone ?? null,
                    'address' => $fav->favoriteMember->address ?? null,
                    'membership_type' => $fav->favoriteMember->membership_type ?? 'free',
                    'favorited_at' => $fav->created_at,
                ];
            });

        // 近日のセミナー
        $upcomingSeminars = Seminar::query()
            ->where('status', 'scheduled')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')->orderBy('start_time', 'asc')
            ->take(6)
            ->get()
            ->filter(function ($s) use ($memberType) {
                return $this->canSeeSeminarForMember($s, $memberType);
            })
            ->values()
            ->map(function ($s) use ($memberType) {
                return [
                    'id' => $s->id,
                    'title' => $s->title,
                    'date' => $s->date,
                    'start_time' => $s->start_time,
                    'end_time' => $s->end_time,
                    'location' => $s->location,
                    'membership_requirement' => $s->membership_requirement,
                    'can_register_for_user' => $this->canRegisterForMemberType($s, $memberType),
                ];
            });

        // 公開済みの最新刊行物（会員限定も含む：会員ダッシュボードのため）
        $recentPublications = Publication::where('is_published', true)
            ->orderBy('publication_date', 'desc')
            ->take(6)
            ->get(['id','title','publication_date','cover_image','is_downloadable','members_only'])
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'publication_date' => $p->publication_date,
                    'cover_image' => $p->cover_image,
                    'members_only' => (bool)$p->members_only,
                    'is_downloadable' => (bool)$p->is_downloadable,
                ];
            });

        // 会員ステータス
        $expiresAt = $member->membership_expires_at;
        $daysLeft = $expiresAt ? now()->diffInDays($expiresAt, false) : null;

        return response()->json([
            'success' => true,
            'data' => [
                'member' => [
                    'id' => $member->id,
                    'company_name' => $member->company_name,
                    'representative_name' => $member->representative_name,
                    'email' => $member->email,
                    'membership_type' => $memberType,
                    'membership_expires_at' => $expiresAt,
                    'is_active' => (bool)$member->is_active,
                    'status' => $member->status,
                ],
                'stats' => [
                    'favorites_count' => $favoritesCount,
                    'upcoming_seminars_count' => $upcomingSeminars->count(),
                    'days_left' => $daysLeft,
                ],
                'recent_favorites' => $recentFavorites,
                'upcoming_seminars' => $upcomingSeminars,
                'recent_publications' => $recentPublications,
            ]
        ]);
    }

    private function canSeeSeminarForMember(Seminar $seminar, string $memberType): bool
    {
        $priority = ['free' => 1, 'standard' => 2, 'premium' => 3];
        $required = $seminar->membership_requirement ?? 'free';
        if (($priority[$memberType] ?? 0) < ($priority[$required] ?? 1)) return false;

        // 解禁日（案A）
        switch ($memberType) {
            case 'premium':
                $open = $seminar->premium_open_at ?? $seminar->standard_open_at ?? $seminar->free_open_at;
                break;
            case 'standard':
                $open = $seminar->standard_open_at ?? $seminar->free_open_at;
                break;
            default:
                $open = $seminar->free_open_at;
        }
        return !$open || now()->gte($open);
    }

    private function canRegisterForMemberType(Seminar $seminar, ?string $memberType): bool
    {
        if (!$seminar->can_register) return false;
        if (!$memberType) return $seminar->membership_requirement === 'free' && (!$seminar->free_open_at || now()->gte($seminar->free_open_at));

        $priority = ['free' => 1, 'standard' => 2, 'premium' => 3];
        $required = $priority[$seminar->membership_requirement] ?? 1;
        if (($priority[$memberType] ?? 0) < $required) return false;

        switch ($memberType) {
            case 'premium':
                $open = $seminar->premium_open_at ?? $seminar->standard_open_at ?? $seminar->free_open_at; break;
            case 'standard':
                $open = $seminar->standard_open_at ?? $seminar->free_open_at; break;
            default:
                $open = $seminar->free_open_at;
        }
        return !$open || now()->gte($open);
    }
}

