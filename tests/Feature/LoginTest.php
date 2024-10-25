<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\BaseTestCase;

class LoginTest extends BaseTestCase
{
    public function testValidCredentials()
    {
        $response = $this->setUpLoginTest([
            'email' => 'rodrigopaco.1986@gmail.com',
            'password' => 'admin',
        ]);

        $this->assertCommonSuccessResponse($response);
    }

    public function testInvalidCredentials()
    {
        $faker = Factory::create();

        // Expected response: {"success":false,"data":{"name":"", "email":""}}
        $response = $this->setUpLoginTest([
            'email' => 'rodrigopaco.1986@gmail.com',
            'password' => $faker->text(10),
        ]);

        $this->assertCommonFailedResponse($response);

        $this->assertEquals('Invalid credentials!', $response['message']);
    }

    public function testClientNotFound()
    {
        $faker = Factory::create();

        $email = microtime().$faker->email();
        // Expected response: {"success":false,"message":"","data":{"email":""}}
        $response = $this->setUpLoginTest([
            'email' => $email,
            'password' => $faker->text(10),
        ]);

        $this->assertCommonFailedResponse($response);

        $this->assertEquals('Client not found!', $response['message']);
    }

    private function setUpLoginTest(array $data): array
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = $data['email'] ?? '';
        $_POST['password'] = $data['password'] ?? '';

        ob_start();
        $response = $this->response;
        include __DIR__.'/../../login.php';
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
