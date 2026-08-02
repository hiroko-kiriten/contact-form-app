<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_index_can_be_displayed()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/admin');

        $response->assertStatus(200);
    }

    public function test_contacts_can_be_searched_by_keyword(): void
    {
        $user = User::factory()->create();

        Contact::factory()->create([
            'first_name' => '山田',
            'last_name' => '太郎',
        ]);

        Contact::factory()->create([
            'first_name' => '佐藤',
            'last_name' => '花子',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/admin?keyword=山田');

        $response->assertStatus(200);
        $response->assertSee('山田');
        $response->assertDontSee('佐藤');
    }

    public function test_contacts_are_paginated_by_seven(): void
    {
        $user = User::factory()->create();

        Contact::factory()->count(8)->create();

        $response = $this->actingAs($user)
            ->get('/admin');

        $response->assertStatus(200);

        $contacts = $response->viewData('contacts');

        $this->assertCount(7, $contacts);
    }

    public function test_contact_detail_can_be_displayed(): void
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create([
            'first_name' => '山田',
            'last_name' => '太郎',
            'email' => 'yamada@example.com',
        ]);

        $response = $this->actingAs($user)
            ->get("/admin/contacts/{$contact->id}");

        $response->assertStatus(200);

        $response->assertSee('山田');
        $response->assertSee('太郎');
        $response->assertSee('yamada@example.com');
    }

    public function test_contact_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)
            ->delete("/admin/contacts/{$contact->id}");

        $response->assertRedirect('/admin');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/admin');

        $response->assertStatus(200);
    }
}
