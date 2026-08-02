<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_can_be_created(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/admin/tags', [
                'name' => 'テストタグ',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tags', [
            'name' => 'テストタグ',
        ]);
    }

    public function test_tag_can_be_updated(): void
{
    $user = User::factory()->create();

    $tag = Tag::factory()->create([
        'name' => '更新前タグ',
    ]);

    $response = $this->actingAs($user)
        ->put("/admin/tags/{$tag->id}", [
            'name' => '更新後タグ',
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('tags', [
        'id' => $tag->id,
        'name' => '更新後タグ',
    ]);
}
}