<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_has_many_contacts(): void
    {
        $tag = Tag::factory()->create();

        $contact = Contact::factory()->create();

        $contact->tags()->attach($tag->id);

        $this->assertTrue(
            $tag->contacts->contains($contact)
        );
    }
}
