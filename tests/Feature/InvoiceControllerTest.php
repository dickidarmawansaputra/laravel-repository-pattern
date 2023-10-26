<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $userId;
    protected $invoice;
    protected $key;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->count(5)->create();
        $userId = User::inRandomOrder()->first();
        $this->userId = $userId;
        $this->invoice = Invoice::factory()->state([
            'user_id' => $userId->id
        ])->count(5)->create();
        $this->key = rand(0, 4);
    }

    public function test_get_list_of_invoice(): void
    {
        $key = $this->key;
        $invoice = $this->invoice;

        $response = $this->get('/api/invoice');

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->hasAll(['code', 'status', 'message', 'data'])
                        ->where('code', 200)
                        ->where('status', Response::$statusTexts[Response::HTTP_OK])
                        ->where('message', '')
                        ->has('data', fn ($json) =>
                            $json->has($key, fn ($json) =>
                                $json->where('invoice_id', $invoice[$key]['id'])
                                ->where('invoice_number', $invoice[$key]['invoice_number'])
                                ->where('invoice_amount', $invoice[$key]['amount'])
                                ->where('invoice_note', $invoice[$key]['note'])
                                ->where('invoice_date', $invoice[$key]['created_at']->format('d F Y H:i'))
                                ->has('invoice_user')
                            )
                            ->etc()
                        )
                );
    }
    
    public function test_get_invoice_details_by_invoice_number(): void
    {
        $key = $this->key;
        $invoice = $this->invoice;

        $response = $this->get("/api/invoice/{$invoice[$key]['invoice_number']}");

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->hasAll(['code', 'status', 'message', 'data'])
                        ->where('code', 200)
                        ->where('status', Response::$statusTexts[Response::HTTP_OK])
                        ->where('message', '')
                        ->has('data', fn (AssertableJson $json) =>
                            $json->where('invoice_id', $invoice[$key]['id'])
                                ->where('invoice_number', $invoice[$key]['invoice_number'])
                                ->where('invoice_amount', $invoice[$key]['amount'])
                                ->where('invoice_note', $invoice[$key]['note'])
                                ->where('invoice_date', $invoice[$key]['created_at']->format('d F Y H:i'))
                                ->has('invoice_user')
                        )
                );
    }
    
    public function test_create_invoice(): void
    {
        $key = $this->key;
        $invoice = $this->invoice;

        $response = $this->post('/api/invoice', $invoice[$key]->only('user_id', 'amount', 'note'));

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->hasAll(['code', 'status', 'message', 'data'])
                        ->where('code', 200)
                        ->where('status', Response::$statusTexts[Response::HTTP_OK])
                        ->where('message', '')
                        ->has('data', fn (AssertableJson $json) =>
                            $json->where('invoice_id', $response->json()['data']['invoice_id'])
                                ->where('invoice_number', $response->json()['data']['invoice_number'])
                                ->where('invoice_amount', $invoice[$key]['amount'])
                                ->where('invoice_note', $invoice[$key]['note'])
                                ->where('invoice_date', $invoice[$key]['created_at']->format('d F Y H:i'))
                                ->has('invoice_user')
                                ->etc()
                        )
                );

    }
    
    public function test_update_invoice(): void
    {
        $key = $this->key;
        $invoice = $this->invoice;

        $response = $this->put('/api/invoice', $invoice[$key]->only('user_id', 'invoice_number', 'amount', 'note'));

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->hasAll(['code', 'status', 'message', 'data'])
                        ->where('code', 200)
                        ->where('status', Response::$statusTexts[Response::HTTP_OK])
                        ->where('message', '')
                        ->has('data', fn (AssertableJson $json) =>
                            $json->where('invoice_id', $response->json()['data']['invoice_id'])
                                ->where('invoice_number', $response->json()['data']['invoice_number'])
                                ->where('invoice_amount', $invoice[$key]['amount'])
                                ->where('invoice_note', $invoice[$key]['note'])
                                ->where('invoice_date', $invoice[$key]['created_at']->format('d F Y H:i'))
                                ->has('invoice_user')
                                ->etc()
                        )
                );

    }

    public function test_delete_invoice(): void
    {
        $key = $this->key;
        $invoice = $this->invoice;

        $response = $this->delete("/api/invoice/{$invoice[$key]['invoice_number']}");

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->hasAll(['code', 'status', 'message', 'data'])
                        ->where('code', 200)
                        ->where('status', Response::$statusTexts[Response::HTTP_OK])
                        ->where('message', '')
                        ->where('data', true)
                );

    }
}
