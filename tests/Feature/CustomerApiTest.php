<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Laravel\Passport\Passport;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function customer_creation()
    {
        // Create a test user and authenticate with Passport
        $user = User::factory()->create();
        Passport::actingAs($user, ['*']);

        // Send API request to create a customer
        $response = $this->postJson('/api/customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'age' => 30,
            'dob' => '1994-05-10',
        ]);

        // Log response for debugging
        $response->dump();

        // Assert response is successful (201 Created)
        $response->assertStatus(201);

        // Verify data in database
        $this->assertDatabaseHas('customer', [ // Ensure correct table name
            'first_name' => 'John',
            'email' => 'johndoe@example.com'
        ]);
    }
}
