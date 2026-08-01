<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Tag;

class ContactFormTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_contact_form_page_can_be_displayed(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_contact_confirm_page_can_be_displayed(): void
    {
        $category = Category::factory()->create();

        $tag = Tag::factory()->create();

        $response = $this->post('/contacts/confirm', [
            'category_id' => $category->id,
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '08012345678',
            'address' => '東京都渋谷区',
            'building' => 'テストビル',
            'detail' => 'テスト内容',
            'tag_ids' => [$tag->id],
    ]);

    $response->assertStatus(200);
}

public function test_contact_can_be_stored(): void
{
    $category = Category::factory()->create();

    $tag = Tag::factory()->create();

    $response = $this->post('/contacts', [
        'category_id' => $category->id,
        'first_name' => '山田',
        'last_name' => '太郎',
        'gender' => 1,
        'email' => 'test@example.com',
        'tel' => '08012345678',
        'address' => '東京都渋谷区',
        'building' => 'テストビル',
        'detail' => 'お問い合わせ内容',
        'tag_ids' => [$tag->id],
    ]);

    $response->assertRedirect('/thanks');

    $this->assertDatabaseHas('contacts', [
        'first_name' => '山田',
        'last_name' => '太郎',
        'email' => 'test@example.com',
    ]);

    $this->assertDatabaseHas('contact_tag', [
        'tag_id' => $tag->id,
    ]);
}
}
