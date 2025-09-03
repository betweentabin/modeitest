<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailGroup;
use App\Models\MailGroupMember;
use App\Models\Member;
use Illuminate\Http\Request;

class MailGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = MailGroup::query()->withCount('members');

        if ($request->filled('search')) {
            $q = $request->get('search');
            $query->where('name', 'like', "%{$q}%");
        }

        $groups = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 20));
        return response()->json(['success' => true, 'data' => $groups]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = MailGroup::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => optional($request->user())->id,
        ]);

        return response()->json(['success' => true, 'data' => $group], 201);
    }

    public function show($id)
    {
        $group = MailGroup::with(['members' => function ($q) {
            $q->with('member:id,company_name,representative_name,email');
        }])->findOrFail($id);

        return response()->json(['success' => true, 'data' => $group]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = MailGroup::findOrFail($id);
        $group->update($validated);

        return response()->json(['success' => true, 'data' => $group]);
    }

    public function destroy($id)
    {
        $group = MailGroup::findOrFail($id);
        $group->delete();
        return response()->json(['success' => true]);
    }

    // Bulk add/remove members
    public function members(Request $request, $id)
    {
        $validated = $request->validate([
            'action' => 'required|in:add,remove',
            'member_ids' => 'required|array',
            'member_ids.*' => 'integer|exists:members,id',
        ]);

        $group = MailGroup::findOrFail($id);

        if ($validated['action'] === 'add') {
            $now = now();
            $toInsert = [];
            foreach ($validated['member_ids'] as $memberId) {
                $toInsert[] = [
                    'group_id' => $group->id,
                    'member_id' => $memberId,
                    'created_at' => $now,
                ];
            }
            // Insert ignoring duplicates
            foreach ($toInsert as $row) {
                MailGroupMember::firstOrCreate([
                    'group_id' => $row['group_id'],
                    'member_id' => $row['member_id'],
                ], ['created_at' => $row['created_at']]);
            }
        } else {
            MailGroupMember::where('group_id', $group->id)
                ->whereIn('member_id', $validated['member_ids'])
                ->delete();
        }

        $count = MailGroupMember::where('group_id', $group->id)->count();
        return response()->json(['success' => true, 'member_count' => $count]);
    }
}

