<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    public function store(StoreTagRequest $request)
    {
        Tag::create([
            'name' => $request->name,
        ]);

        return redirect('/admin');
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return view('admin.tags.edit', compact('tag'));
    }

    public function update(StoreTagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $tag->update([
            'name' => $request->name,
        ]);

        return redirect('/admin');
    }
}
