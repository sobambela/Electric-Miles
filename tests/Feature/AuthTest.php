<?php

namespace Tests\Feature;

use DB;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    /** @test */

    public function testGetAccessToken()
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

        $response->assertStatus(200);
        // Receive our token
        $this->assertArrayHasKey('access_token', $response->json());
    }

    
}
