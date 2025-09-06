<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoticeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NoticeCategoryController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>true, 'data'=> NoticeCategory::ordered()->get()]);
    }
    public function show($id)
    {
        return response()->json(['success'=>true, 'data'=> NoticeCategory::findOrFail($id)]);
    }
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:notice_categories,slug',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        $data = $request->only(['name','slug','sort_order','is_active']);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        $item = NoticeCategory::create($data);
        return response()->json(['success'=>true,'data'=>$item], 201);
    }
    public function update(Request $request, $id)
    {
        $item = NoticeCategory::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:notice_categories,slug,' . $item->id,
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        $data = $request->only(['name','slug','sort_order','is_active']);
        if (isset($data['name']) && empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        $item->update($data);
        return response()->json(['success'=>true,'data'=>$item]);
    }
    public function destroy($id)
    {
        $item = NoticeCategory::findOrFail($id);
        $item->delete();
        return response()->json(['success'=>true]);
    }
}

