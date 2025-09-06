<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicationCategoryController extends Controller
{
    public function index()
    {
        return response()->json(['success'=>true, 'data'=> PublicationCategory::ordered()->get()]);
    }
    public function show($id)
    {
        return response()->json(['success'=>true, 'data'=> PublicationCategory::findOrFail($id)]);
    }
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:publication_categories,slug',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($v->fails()) return response()->json(['success'=>false,'errors'=>$v->errors()], 422);
        $data = $request->only(['name','slug','sort_order','is_active']);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        $item = PublicationCategory::create($data);
        return response()->json(['success'=>true,'data'=>$item], 201);
    }
    public function update(Request $request, $id)
    {
        $item = PublicationCategory::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:publication_categories,slug,' . $item->id,
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
        $item = PublicationCategory::findOrFail($id);
        // if ($item->publications()->exists()) return response()->json(['success'=>false,'message'=>'関連する刊行物があります'], 422);
        $item->delete();
        return response()->json(['success'=>true]);
    }
}

