# Tatter\Imposter
Mock authentication for CodeIgniter 4

[![](https://github.com/tattersoftware/codeigniter4-imposter/workflows/PHPUnit/badge.svg)](https://github.com/tattersoftware/codeigniter4-imposter/actions/workflows/test.yml)
[![](https://github.com/tattersoftware/codeigniter4-imposter/workflows/PHPStan/badge.svg)](https://github.com/tattersoftware/codeigniter4-imposter/actions/workflows/analyze.yml)
[![](https://github.com/tattersoftware/codeigniter4-imposter/workflows/Deptrac/badge.svg)](https://github.com/tattersoftware/codeigniter4-imposter/actions/workflows/inspect.yml)
[![Coverage Status](https://coveralls.io/repos/github/tattersoftware/codeigniter4-imposter/badge.svg?branch=develop)](https://coveralls.io/github/tattersoftware/codeigniter4-imposter?branch=develop)

## Quick Start

1. Install with Composer: `> composer require --dev tatter/imposter`
2. Access via the service: `$user = service('auth')->user();`

## Description

`Imposter` provides a thin authentication layer for testing your CodeIgniter apps that
require authentication. This library is for **testing purposes only**. The tiny footprint
and easy-to-use interfaces make it ideal for handling mock authentication in a rapid way.

`Imposter` fulfills all the [CodeIgniter authentication guidelines](https://codeigniter4.github.io/CodeIgniter4/extending/authentication.html)
and thus supplies the Composer provision for `codeigniter4/authentication-implementation`.

## Installation

Install easily via Composer to take advantage of CodeIgniter 4's autoloading capabilities
and always be up-to-date:
* `> composer require tatter/imposter`

Or, install manually by downloading the source files and adding the directory to
`app/Config/Autoload.php`.

## Usage

Use the service to log a user in or out.

```php
service('auth')->login($userId);
service('auth')->logout();
```

The current status can be checked by getting the ID or User; both will be `null` if no
user is authenticated.

```php
if ($user = service('auth')->user()) {
	echo 'Logged in!';
}
```

You may also load the helper to use the `user_id()` convenience method as outlined in the
[CodeIgniter authentication guidelines](https://codeigniter4.github.io/CodeIgniter4/extending/authentication.html).

```php
helper('auth');

if ($userId = user_id()) {
	return true;
}

throw new RuntimeException('You must be authenticated!');
```
