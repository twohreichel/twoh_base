<?php

declare(strict_types=1);

namespace TWOH\TwohBase\Configuration;

use TYPO3\CMS\Core\Core\ApplicationContext;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Class Loader
 * @package TWOH\TwohBase\Configuration
 */
class Loader
{
    /**
     * @var ApplicationContext
     */
    protected ApplicationContext $context;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @param ApplicationContext $context
     * @param string $rootPath Project root path where the "config" directory is located
     */
    public function __construct(ApplicationContext $context, string $rootPath)
    {
        $this->context = $context;
        $this->path = rtrim($rootPath, '/') . '/';
    }

    /**
     * Load the configuration from the given base path
     *
     * This should be called from typo3conf/AdditionalConfiguration.php
     *
     * @return void
     */
    public function load(): void
    {
        $filePaths = $this->getFilePaths();
        // Only allow existing files/directories
        $filePaths = array_filter($filePaths, 'file_exists');

        $typo3Settings = [];
        ArrayUtility::mergeRecursiveWithOverrule($typo3Settings, (array)include $filePaths[0]);
        ArrayUtility::mergeRecursiveWithOverrule($typo3Settings, (array)include $filePaths[1]);
        ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TYPO3_CONF_VARS'], $typo3Settings);
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
        $configRootPath = $this->path . 'config/';
        $context = $this->context;

        do {
            $contextName = (string) $context;
            $filePaths[] = $configRootPath . strtolower(str_replace('/', '.', $contextName)) . '.php';

            $context = $context->getParent();
        } while ($context !== null);

        $filePaths[] = $configRootPath . 'default.php';
        $filePaths = array_reverse($filePaths);

        return $filePaths;
    }
}
