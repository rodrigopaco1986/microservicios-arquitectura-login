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

    public function testUpdateSettingsLoggerToHttp()
    {
        // Expected response: {"success":true,"data":{"logger":"Rpj\\Login\\Logger\\Concrete\\HttpLogger"}}
        $response = $this->setUpLoggerTest(SETTINGS_LOGGER_HTTP);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(HttpLogger::class, $response['data']['logger']);
    }

    public function testUpdateSettingsLoggerToDatabase()
    {
        // Expected response: {"success":true,"data":{"logger":"Rpj\\Login\\Logger\\Concrete\\DatabaseLogger"}}
        $response = $this->setUpLoggerTest(SETTINGS_LOGGER_DATABASE);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(DatabaseLogger::class, $response['data']['logger']);
    }

    public function testUpdateSettingsLoggerToNull()
    {
        // Expected response: {"success":true,"data":{"logger":"Rpj\\Login\\Logger\\Concrete\\NullLogger"}}
        $response = $this->setUpLoggerTest(SETTINGS_LOGGER_NONE);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(NullLogger::class, $response['data']['logger']);
    }

    public function testUpdateSettingsEncryptionToMd5()
    {
        // Expected response: {"success":true,"data":{"encryption":"Rpj\\Login\\Encryption\\MD5Encryption"}}
        $response = $this->setEncryptionTest(SETTINGS_ENCRYPTION_MD5);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(MD5Encryption::class, $response['data']['encryption']);
    }

    public function testUpdateSettingsEncryptionToCrypt()
    {
        // Expected response: {"success":true,"data":{"encryption":"Rpj\\Login\\Encryption\\CryptEncryption"}}
        $response = $this->setEncryptionTest(SETTINGS_ENCRYPTION_CRYPT);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(CryptEncryption::class, $response['data']['encryption']);
    }

    public function testUpdateSettingsEncryptionToBcrypt()
    {
        // Expected response: {"success":true,"data":{"encryption":"Rpj\\Login\\Encryption\\BcryptEncryption"}}
        $response = $this->setEncryptionTest(SETTINGS_ENCRYPTION_BCRYPT);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(BcryptEncryption::class, $response['data']['encryption']);
    }

    public function testUpdateSettingsEncryptionToNull()
    {
        // Expected response: {"success":true,"data":{"encryption":"Rpj\\Login\\Encryption\\NullEncryption"}}
        $response = $this->setEncryptionTest(SETTINGS_ENCRYPTION_NONE);

        $this->assertCommonResponse($response);
        
        $this->assertEquals(NullEncryption::class, $response['data']['encryption']);
    }

    private function setUpLoggerTest(string $logger): array
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['logger'] = $logger;

        ob_start();
        $response = $this->response;
        include __DIR__ . '/../../settings.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);
        
        return $response;
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
