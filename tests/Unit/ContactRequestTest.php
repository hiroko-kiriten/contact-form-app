<?php

namespace Tests\Unit;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ContactRequestTest extends TestCase
{
    public function test_contact_search_validation_passes(): void
    {
        $data = [
            'keyword' => '山田',
            'gender' => 1,
            'category_id' => 1,
            'date' => '2026-07-30',
        ];

        $validator = Validator::make(
            $data,
            (new ContactRequest)->rules()
        );

        $this->assertFalse($validator->fails());
    }

    public function test_contact_search_validation_fails_with_invalid_date(): void
    {
        $data = [
            'date' => 'invalid-date',
        ];

        $validator = Validator::make(
            $data,
            (new ContactRequest)->rules()
        );

        $this->assertTrue($validator->fails());

        $this->assertArrayHasKey(
            'date',
            $validator->errors()->toArray()
        );
    }
}
