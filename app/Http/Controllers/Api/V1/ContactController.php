<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\IndexContactRequest;
use App\Http\Requests\Api\V1\StoreContactRequest;
use App\Http\Requests\Api\V1\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(IndexContactRequest $request)
    {
        $perPage = $request->per_page ?? 20;

        $query = Contact::with([
            'category',
            'tags',
        ]);

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $contacts = $query
            ->latest()
            ->paginate($perPage);

        return ContactResource::collection($contacts);
    }

    public function show(Contact $contact)
    {
        $contact->load([
            'category',
            'tags',
        ]);

        return new ContactResource($contact);
    }  
    
    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        $tagIds = $validated['tag_ids'] ?? [];

        unset($validated['tag_ids']);

        $contact = Contact::create($validated);

        $contact->tags()->attach($tagIds);

        $contact->load([
            'category',
            'tags',
        ]);

    return (new ContactResource($contact))
        ->response()
        ->setStatusCode(201);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $validated = $request->validated();

        $tagIds = $validated['tag_ids'] ?? [];

        unset($validated['tag_ids']);

        $contact->update($validated);

        $contact->tags()->sync($tagIds);

        $contact->load([
            'category',
            'tags',
        ]);

        return new ContactResource($contact);
    }
}