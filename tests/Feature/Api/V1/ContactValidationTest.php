<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function genderが123以外ならバリデーションエラーになる()
    {
        $response = $this->getJson('/api/v1/contacts?gender=5');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('gender');
    }

    /** @test */
    public function dateが日付形式でない場合エラーになる()
    {
        $response = $this->getJson('/api/v1/contacts?date=abc');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('date');
    }

    /** @test */
    public function per_pageが0ならエラーになる()
    {
        $response = $this->getJson('/api/v1/contacts?per_page=0');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('per_page');
    }

    /** @test */
    public function 存在しないカテゴリーならエラーになる()
    {
        $response = $this->getJson('/api/v1/contacts?category_id=999');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('category_id');
    }

    /** @test */
    public function 正しいカテゴリーなら検索できる()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/v1/contacts?category_id={$category->id}");

        $response->assertOk();
    }
}
