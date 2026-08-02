<?php

namespace Tests\Unit;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class StoreTagRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_store_validation_passes(): void
    {
        $validator = Validator::make(
            [
                'name' => 'お問い合わせ',
            ],
            (new StoreTagRequest)->rules()
        );

        $this->assertFalse($validator->fails());
    }

    public function test_tag_store_validation_fails_when_name_is_duplicate(): void
    {
        Tag::factory()->create([
            'name' => 'お問い合わせ',
        ]);

        $validator = Validator::make(
            [
                'name' => 'お問い合わせ',
            ],
            (new StoreTagRequest)->rules()
        );

        $this->assertTrue($validator->fails());
    }

    public function test_tag_update_allows_same_name(): void
    {
        $tag = Tag::factory()->create([
            'name' => 'お問い合わせ',
        ]);

        $validator = Validator::make(
            [
                'name' => 'お問い合わせ',
            ],
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('tags', 'name')
                        ->ignore($tag->id),
                ],
            ]
        );

        $this->assertFalse($validator->fails());
    }

    public function test_tag_update_fails_when_using_other_tag_name(): void
    {
        $tag1 = Tag::factory()->create([
            'name' => 'お問い合わせ',
        ]);

        Tag::factory()->create([
            'name' => '製品',
        ]);

        $validator = Validator::make(
            [
                'name' => '製品',
            ],
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('tags', 'name')
                        ->ignore($tag1->id),
                ],
            ]
        );

        $this->assertTrue($validator->fails());
    }
}
