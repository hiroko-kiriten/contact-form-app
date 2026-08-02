<?php

namespace Tests\Unit;

use App\Http\Requests\StoreContactRequest;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreContactRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_store_validation_passes(): void
    {
        $category = Category::factory()->create();

        $data = [
            'first_name' => '山田',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '08012345678',
            'address' => '東京都',
            'building' => 'テストビル',
            'category_id' => $category->id,
            'detail' => 'お問い合わせ内容',
        ];

        $validator = Validator::make(
            $data,
            (new StoreContactRequest())->rules()
        );

        $this->assertFalse($validator->fails());
    }


    public function test_contact_store_validation_fails_without_required_fields(): void
    {
        $data = [];

        $validator = Validator::make(
            $data,
            (new StoreContactRequest())->rules()
        );

        $this->assertTrue($validator->fails());

        $this->assertArrayHasKey(
            'first_name',
            $validator->errors()->toArray()
        );

        $this->assertArrayHasKey(
            'email',
            $validator->errors()->toArray()
        );
    }
}