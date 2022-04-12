<?php

namespace Tests\Feature;

use DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;

class OdersTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    /**
     * Gets API access token.
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
        $this->withoutExceptionHandling();

        $client = DB::table('oauth_clients')
            ->find(2);

        User::factory(1)->create();

        $response = $this->json('POST', '/oauth/token', [
            "grant_type"  =>  "password",
            "client_id"  =>  "2",
            "client_secret"  => $client->secret,
            "username"  => "test@test.com",
            "password"  => "password"
        ],  ['Accept' => 'application/json']);

        return $response->json()['access_token'];
    }

    /** @test */
    public function test_create_order()
    {
        $accessToken = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'Content-Type' => 'application/json'
        ])->json('POST', '/api/v1/orders', [
            'customer_id' => '1',
            'exptected_delivery_time' => date('Y-m-d H:s:i'),
            'delivery_address' => 'C559A, Indlulamti Cress, Site C, Khayelitsha, 7784',
            'billing_address' => 'C559A, Indlulamti Cress, Site C, Khayelitsha, 7784',
            'items' => [
                [
                    "item_id" => 2,
                    "quantity" => 6
                ],
                [
                    "item_id" => 3,
                    "quantity" => 3
                ]
            ]
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }

    /** @test */
    public function test_update_order()
    {

        Order::factory(5)->create();

        $accessToken = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'Content-Type' => 'application/json'
        ])->json('PATCH', '/api/v1/orders/1?order_status=DELIVERED');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }

    /** @test */
    public function test_delete_order()
    {
        Order::factory(5)->create();

        $accessToken = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'Content-Type' => 'application/json'
        ])->json('DELETE', '/api/v1/orders/5');

        $response->assertStatus(204);
    }

    /** @test */
    public function test_get_all_orders()
    {
        Order::factory(5)->create();

        $accessToken = $this->getAccessToken();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->json('GET', '/api/v1/orders');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }

    /** @test */
    public function test_get_orders_by_status_or_id()
    {
        Order::factory(5)->create();

        $accessToken = $this->getAccessToken();

        // Get orders by Status
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->json('GET', '/api/v1/orders?order_status=DELIVERED');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());

        // Get orders by ID
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->json('GET', '/api/v1/orders/2');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }

    /** @test */
    public function test_get_delayed_orders_by_start_and_end_date()
    {
        Order::factory(5)->create();

        $accessToken = $this->getAccessToken();

        // Get Delayed orders start and end date
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->json('GET', '/api/v1/delayed?start_date=2022-04-12&end_date=2022-04-20');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());

        // Get Delayed orders start date only
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->json('GET', '/api/v1/delayed?start_date=2022-04-12');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());

        // Get Delayed orders end date only
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->json('GET', '/api/v1/delayed?end_date=2022-04-20');

        $response->assertStatus(200);
        $this->assertArrayHasKey('data', $response->json());
    }
}
