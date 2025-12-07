<?php

declare(strict_types=1);

namespace TWOH\TwohBase\Tests\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TWOH\TwohBase\Configuration\Loader;
use TYPO3\CMS\Core\Core\ApplicationContext;

class LoaderTest extends TestCase
{
    private string $tempDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDir = sys_get_temp_dir() . '/twoh_base_test_' . uniqid();
        mkdir($this->tempDir . '/config', 0o777, true);
    }

    protected function tearDown(): void
    {
        // Clean up temp files
        $this->removeDirectory($this->tempDir);
        parent::tearDown();
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->removeDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }

    public function testGetFilePathsReturnsCorrectOrder(): void
    {
        // Create test config files
        $defaultConfig = '<?php return ["DB" => ["default" => true]];';
        $devConfig = '<?php return ["DB" => ["development" => true]];';

        file_put_contents($this->tempDir . '/config/default.php', $defaultConfig);
        file_put_contents($this->tempDir . '/config/development.php', $devConfig);

        $context = new ApplicationContext('Development');
        $loader = new Loader($context, $this->tempDir);

        // Use reflection to test protected method
        $reflection = new ReflectionClass($loader);
        $method = $reflection->getMethod('getFilePaths');
        $method->setAccessible(true);

        $filePaths = $method->invoke($loader);

        self::assertCount(2, $filePaths);
        self::assertStringEndsWith('default.php', $filePaths[0]);
        self::assertStringEndsWith('development.php', $filePaths[1]);
    }

    public function testGetFilePathsWithNestedContext(): void
    {
        $context = new ApplicationContext('Production/Staging');
        $loader = new Loader($context, $this->tempDir);

        $reflection = new ReflectionClass($loader);
        $method = $reflection->getMethod('getFilePaths');
        $method->setAccessible(true);

        $filePaths = $method->invoke($loader);

        self::assertCount(3, $filePaths);
        self::assertStringEndsWith('default.php', $filePaths[0]);
        self::assertStringEndsWith('production.php', $filePaths[1]);
        self::assertStringEndsWith('production.staging.php', $filePaths[2]);
    }

    public function testLoaderConstructorSetsPathCorrectly(): void
    {
        $context = new ApplicationContext('Development');
        $loader = new Loader($context, '/some/path');

        $reflection = new ReflectionClass($loader);
        $property = $reflection->getProperty('path');
        $property->setAccessible(true);

        self::assertEquals('/some/path/', $property->getValue($loader));
    }

    public function testLoaderConstructorHandlesTrailingSlash(): void
    {
        $context = new ApplicationContext('Development');
        $loader = new Loader($context, '/some/path/');

        $reflection = new ReflectionClass($loader);
        $property = $reflection->getProperty('path');
        $property->setAccessible(true);

        self::assertEquals('/some/path/', $property->getValue($loader));
    }
}
