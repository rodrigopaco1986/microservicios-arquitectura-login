<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\BaseTestCase;

class RegisterClientTest extends BaseTestCase
{
    public function testNewValidClient()
    {
        $faker = Factory::create();

        $email = microtime().$faker->email();
        // Expected response: {"success":true,"data":{"name":"", "email":"","password":"","password_crypt":"Rpj\\Login\\Encryption\\CryptEncryption"}}
        $response = $this->setUpRegisterClientTest([
            'name' => $faker->name(),
            'email' => $email,
            'password' => $faker->text(10),
        ]);

        $this->assertCommonSuccessResponse($response);

        $this->assertEquals($email, $response['data']['email']);
    }

    public function testNewDupeClient()
    {
        // Expected response: {"success":false,"message":"User already registered with that email!"}
        $response = $this->setUpRegisterClientTest([
            'name' => 'Rodrigo Paco',
            'email' => 'rodrigopaco.1986@gmail.com',
            'password' => 'admin',
        ]);

        $this->assertCommonFailedResponse($response);

        $this->assertEquals('User already registered with that email!', $response['message']);
    }

    private function setUpRegisterClientTest(array $data): array
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['name'] = $data['name'] ?? '';
        $_POST['email'] = $data['email'] ?? '';
        $_POST['password'] = $data['password'] ?? '';

        ob_start();
        $response = $this->response;
        include __DIR__.'/../../register.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);

        return $response;
    }

    private function assertCommonSuccessResponse($response): void
    {
        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);

        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
        $this->assertArrayHasKey('name', $response['data']);
        $this->assertArrayHasKey('email', $response['data']);
        $this->assertArrayHasKey('password', $response['data']);
        $this->assertArrayHasKey('password_crypt', $response['data']);
    }

    private function assertCommonFailedResponse($response): void
    {
        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
        $this->assertFalse($response['success']);

        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
    }
}
