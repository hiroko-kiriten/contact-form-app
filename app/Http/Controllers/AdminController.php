<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Tag;

class AdminController extends Controller
{
    public function index(ContactRequest $request)
    {
        $categories = Category::all();

        $tags = Tag::all();

        $query = Contact::query();

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->keyword.'%')
                    ->orWhere('last_name', 'like', '%'.$request->keyword.'%')
                    ->orWhere('email', 'like', '%'.$request->keyword.'%');
            });
        }

        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->paginate(7);

        return view('admin.index', compact('categories', 'contacts', 'tags'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('admin.show', compact('contact'));
    }
}
