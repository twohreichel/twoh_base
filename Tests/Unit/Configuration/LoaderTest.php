<?php

declare(strict_types=1);

namespace TWOH\TwohBase\Tests\Unit\Configuration;

use TWOH\TwohBase\Configuration\Loader;
use TYPO3\CMS\Core\Core\ApplicationContext;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use PHPUnit\Framework\TestCase;

class LoaderTest extends TestCase
{
    /**
     * @var Loader
     */
    public Loader $additionalConfiguration;

    /**
     * Configuration file path
     * @var string
     */
    public string $path = '';

    /**
     * @var ApplicationContext
     */
    public ApplicationContext $context;

    /**
     * @test
     */
    public function testConfiguration(): void
    {
        $this->setUp();
        $this->assertArrayHasKey('DB', $this->load());
    }

    public function setUp(): void
    {
        $this->path = Environment::getProjectPath() . '/config/';
        $this->context = new ApplicationContext('Development');
    }

    /**
     * Load the configuration from the given base path
     *
     * This should be called from typo3conf/AdditionalConfiguration.php
     *
     * @return array
     */
    public function load(): array
    {
        $filePaths = $this->getFilePaths();
        // Only allow existing files/directories
        $filePaths = array_filter($filePaths, 'file_exists');

        $typo3Settings = [];
        if (isset($filePaths[0], $filePaths[1])) {
            ArrayUtility::mergeRecursiveWithOverrule($typo3Settings, (array)include $filePaths[0]);
            ArrayUtility::mergeRecursiveWithOverrule($typo3Settings, (array)include $filePaths[1]);
        }

        return $typo3Settings;
    }

    /**
     * Get configuration file paths
     *
     * The returned array looks like this for a context like "Production/Staging":
     *
     * [
     *   '.../config/default.php',
     *   '.../config/common.php',
     *   '.../config/production.php',
     *   '.../config/production.staging.php',
     * ]
     *
     * @return array
     */
    protected function getFilePaths(): array
    {
        $configRootPath = $this->path;
        $filePaths = [];
        $context = $this->context;

        do {
            $contextName = (string) $context;
            $filePaths[] = $configRootPath . strtolower(str_replace('/', '.', $contextName)) . '.php';

            $context = $context->getParent();
        } while ($context !== null);

        $filePaths[] = $configRootPath . 'default.php';

        return array_reverse($filePaths);
    }
}
