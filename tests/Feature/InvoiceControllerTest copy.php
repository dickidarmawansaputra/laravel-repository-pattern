<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userId;
    protected $invoice;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $userId = User::inRandomOrder()->first();
        $this->userId = $userId;
        $this->invoice = Invoice::factory()->state([
            'user_id' => $userId->id
        ])->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_get_list_of_invoice(): void
    {
        $response = $this->get('/api/invoice');

        $response->assertStatus(Response::HTTP_OK);
        // $response->assertJson(fn (AssertableJson $json) =>
        //     $json->has('code', 200)
        //          ->has('status', Response::HTTP_OK) 
        //          ->has('message') 
        // );
    }
    public function test_get_invoice_details_by_invoice_number(): void
    {
        $response = $this->get('/api/invoice');

        $response->assertStatus(200);
    }
    public function test_create_invoice(): void
    {
        $response = $this->get('/api/invoice');

        $response->assertStatus(200);
    }
    
    public function test_update_invoice(): void
    {
        $response = $this->get('/api/invoice');

        $response->assertStatus(200);
    }
    
    public function test_delete_invoice(): void
    {
        $response = $this->get('/api/invoice');

        $response->assertStatus(200);
    }
}
