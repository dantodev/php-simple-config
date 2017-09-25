[![Latest Stable Version](https://poser.pugx.org/dtkahl/php-simple-config/v/stable)](https://packagist.org/packages/dtkahl/php-simple-config)
[![License](https://poser.pugx.org/dtkahl/php-simple-config/license)](https://packagist.org/packages/dtkahl/php-simple-config)
[![Build Status](https://travis-ci.org/dtkahl/php-simple-config.svg?branch=master)](https://travis-ci.org/dtkahl/php-simple-config)


# PHP simple config

This is a simple config handler class with dot-syntax for PHP.

#### Dependencies

* `PHP >= 5.6.0`


#### Installation

Install with [Composer](http://getcomposer.org):
```
composer require dtkahl/php-simple-config
```


### Usage

Refer namespace:

```
use Dtkahl\SimpleConfig\Config;
```

Create new Config instance:

```php
$config = new Config([
    "database" => [
      "host" => "localhost",
      "port" => 1337,
      "username" => "developer",> 1337,
38
      "usernam
      "password" => "secret",
    ],
    "debug" => true,
    // ...
);
```

you can also load Config from file:

```php
$config = new Config(require("./config.php"));
```


Example `config.php`:

```php
<?php
return [
  "database" => [
    "host" => "localhost",
    "port" => 1337,
    "username" => "developer",
    "password" => "secret",
  ],
  "debug" => true,
  // ...
]
```


### Methods

#### `has($path)`
Determine if config entry exists on given path.

#### `get($path, $default = null)`
Returns config entry exists on given path or returns `$default` if path does not exist in config.

#### `set($path, $value, $force = false)`
Set config entry on given path (override if existing). Set parameter `$force` if given path dosn't exist. 
Returns config instance.

#### `remove($path)`
Remove config entry on given path if existing. Returns config instance.

#### `setAlias($alias, $path)`
Add an alias for a given path. Alias should not contain a dot for obvious reason.
