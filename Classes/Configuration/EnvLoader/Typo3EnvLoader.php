<?php

declare(strict_types=1);

namespace TWOH\TwohBase\Configuration\EnvLoader;

use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Class Typo3EnvLoader
 */
class Typo3EnvLoader
{
    /**
     * @return array
     */
    public function load(): array
    {
        $content = [];
        $prefix = 'TYPO3_';
        foreach ($_ENV as $name => $value) {
            if (str_starts_with($name, $prefix)) {
                $path = str_replace('__', '/', substr($name, \strlen($prefix)));
                $content = ArrayUtility::setValueByPath($content, $path, $value);
            }
        }
        return $content;
    }
}
