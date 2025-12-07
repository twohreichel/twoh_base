# TWOH Base

[![TYPO3 13](https://img.shields.io/badge/TYPO3-13-orange.svg)](https://get.typo3.org/version/13)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://www.php.net/)
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0)

> This extension allows you to move the TYPO3 context into separate files instead of working with the `AdditionalConfiguration.php`.

---

## 📋 Features

- **Context-based Configuration** – Organize TYPO3 settings per environment (Development, Production, etc.)
- **Environment Variables Support** – Includes `.env` support for TYPO3's `AdditionalConfiguration.php`
- **Clean Project Setup** – Provides all needed files for setting up a TYPO3 project

---

## ⚙️ Requirements

| Requirement | Version |
|-------------|---------|
| PHP         | ^8.2    |
| Composer    | ^2.0    |
| TYPO3       | ^13.4   |

---

## 🚀 Installation

### Via Composer (recommended)

```bash
composer require twoh/twoh_base
```

### Manual Installation

1. Download the extension
2. Upload to `typo3conf/ext/twoh_base`
3. Activate in TYPO3 Extension Manager

---

## 📖 Usage

### Configuration Structure

Create a `config/` directory in your project root with environment-specific configuration files:

```
project-root/
├── config/
│   ├── default.php          # Base configuration (loaded first)
│   ├── development.php      # Development environment
│   ├── production.php       # Production environment
│   └── production.staging.php  # Production/Staging context
```

### Example Configuration File

```php
<?php
// config/default.php
return [
    'DB' => [
        'Connections' => [
            'Default' => [
                'host' => 'localhost',
                'dbname' => 'typo3',
            ],
        ],
    ],
];
```

### Loading Configuration

Add to your `AdditionalConfiguration.php`:

```php
<?php
use TWOH\TwohBase\Configuration\Loader;
use TYPO3\CMS\Core\Core\Environment;

$loader = new Loader(
    Environment::getContext(),
    Environment::getProjectPath()
);
$loader->load();
```

---

## 🧪 Development

### Running Tests

```bash
composer test:unit
```

### Code Style

```bash
# Check code style
composer cs:check

# Fix code style
composer cs:fix
```

---

## 📄 License

This project is licensed under the GPL-2.0-or-later License – see the [LICENSE](LICENSE) file for details.

---

## 👥 Authors

- **Andreas Reichel** – [a.reichel91@outlook.com](mailto:a.reichel91@outlook.com)
- **Igor Smertin** – [igor.smertin@web.de](mailto:igor.smertin@web.de)

---

## 🔗 Links

- [GitHub Repository](https://github.com/twohreichel/twoh_base)
- [Issue Tracker](https://github.com/twohreichel/twoh_base/issues)
- [Documentation](https://docs.typo3.org/p/twoh/twoh_base/main/en-us/)