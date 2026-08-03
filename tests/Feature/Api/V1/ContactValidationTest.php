<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\Tag;
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

        /** @test */
    public function 正しいデータなら問い合わせを作成できる()
    {
        $category = Category::factory()->create();

        $tag = Tag::factory()->create();

        $data = [
            'category_id' => $category->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都',
            'building' => 'テストビル',
            'detail' => 'お問い合わせ内容',
            'tag_ids' => [
                $tag->id,
            ],
        ];

        $response = $this->postJson('/api/v1/contacts', $data);

        $response->assertStatus(201);
    }


    /** @test */
    public function genderが不正ならエラーになる()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/v1/contacts', [
            'category_id' => $category->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'gender' => 5,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('gender');
    }


    /** @test */
    public function emailが不正ならエラーになる()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/v1/contacts', [
            'category_id' => $category->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'gender' => 1,
            'email' => 'abc',
            'tel' => '09012345678',
            'address' => '東京都',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }


    /** @test */
    public function 存在しないタグならエラーになる()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/v1/contacts', [
            'category_id' => $category->id,
            'first_name' => '太郎',
            'last_name' => '山田',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都',
            'tag_ids' => [999],
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors('tag_ids.0');
    }
}
