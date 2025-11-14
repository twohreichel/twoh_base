============
User Manual v1.0.1
============

.. contents:: Table of Contents
   :depth: 2
   :local:

Introduction
============

The *TWOH Base* extension allows for loading TYPO3 configuration from context-based files
(e.g. `config/development.php`, `config/production.php`, etc.) instead of modifying 
`AdditionalConfiguration.php` directly.

Features:

- Use `.env` for managing TYPO3 context
- Automatically loads config from the appropriate context file
- Overwrites templates and controllers from `we_cookie_consent`
- Better project structure and separation of environments

----

System Requirements
===================

- **PHP:** 8.0 or higher
- **Composer:** 2.0 or higher
- **TYPO3:** 12 LTS

----

Installation
============

1. Install via Composer:

.. code-block:: bash

   composer require twoh/twoh_base

or manually upload to `/typo3conf/ext/`.

2. Add the extension's TypoScript to your **Root Template**.

----

Configuration
=============

The extension expects a `/config/` folder at the project root with files like:

- `default.php`
- `common.php`
- `production.php`
- `production.staging.php`

In your `AdditionalConfiguration.php`, call the loader:

.. code-block:: php

   use TYPO3\CMS\Core\Core\ApplicationContext;
   use TWOH\TwohBase\Configuration\Loader;

   (new Loader(new ApplicationContext($_ENV['TYPO3_CONTEXT'] ?? 'Production'), __DIR__ . '/../'))
       ->load();

Your config files should return arrays in the format expected by `$GLOBALS['TYPO3_CONF_VARS']`.

----

How It Works
============

- The `Loader` class checks TYPO3 context (e.g. `Production/Staging`)
- It loads and merges configuration files in order of specificity:
  `default.php` → `common.php` → `production.php` → `production.staging.php`
- Final settings are applied to `$GLOBALS['TYPO3_CONF_VARS']`

----

Changelog
=========

**1.0.1**
---------
- Improved context file loading order
- Refactored loader class
- added documentation
- added CI & Release

**1.0.0**
---------
- Initial release
- Environment-based configuration structure
- .env context support and loader integration
- Added unit tests

