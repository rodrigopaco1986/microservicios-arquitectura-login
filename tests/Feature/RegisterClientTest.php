<?php

namespace Tests\Feature;

use Tests\BaseTestCase;
use Rpj\Login\Logger\Concrete\{FileLogger, HttpLogger, DatabaseLogger, NullLogger};
use Rpj\Login\Encryption\{MD5Encryption, BcryptEncryption, CryptEncryption, NullEncryption};

class UpdateSettingsTest extends BaseTestCase
{
    public function testUpdateSettingsLoggerToFile()
    {
        // Expected response: {"success":true,"data":{"logger":"Rpj\\Login\\Logger\\Concrete\\FileLogger"}}
        $response = $this->setUpLoggerTest(SETTINGS_LOGGER_FILE);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(FileLogger::class, $response['data']['logger']);
    }

    private function setEncryptionTest(string $encryption): array
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['encryption'] = $encryption;

        ob_start();
        $response = $this->response;
        include __DIR__ . '/../../settings.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);
        
        return $response;
    }

    private function assertCommonResponse($response): void
    {
        $this->assertIsArray($response);
        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);

        $this->assertArrayHasKey('data', $response);
        $this->assertIsArray($response['data']);
        $this->assertArrayHasKey('logger', $response['data']);
        $this->assertArrayHasKey('encryption', $response['data']);
    }

    
}
