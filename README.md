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

## Users

`Imposter` comes with a minimal set of classes to be fully compatible with
[Tatter\Users](https://github.com/tattersoftware/codeigniter4-users). This means that any
project or library which uses the interfaces from `Tatter\Users` can be tested using
`Imposter` without the need of an actual authentication library or even a database.

### User Entity

The `Tatter\Imposter\Entities\User` entity class implements all three entity interfaces from
`Tatter\Users`: `UserEntity`, `HasGroup`, and `HasPermission`. Use it like any regular entity,
except that the `$groups` and `$permissions` atributes are simple CSV casts for storing your
entity relationships:
```php
$user = new \Tatter\Imposter\Entities\User();
$user->groups = ['Administrators', 'Editors'];
```

### Imposter Factory

The `ImposterFactory` class allows `UserProvider` to use the `Imposter` classes automatically
during testing. To enable `ImposterFactory` add it to the list of providers during
your test's `setUp` or `setUpBeforeClass` phase:
```php
<?php

use CodeIgniter\Test\CIUnitTestCase;
use Tatter\Imposter\Factories\ImposterFactory;
use Tatter\Users\UserProvider;

final class UserWidgetTest extends CIUnitTestCase
{
    public static setUpBeforeClass(): void
    {
        UserProvider::add(ImposterFactory::class, ImposterFactory::class);
    }
...
```

Because `Imposter` is a database-free solution `UserFactory` has its own local storage for
`User` entities. Use the static methods to manipulate the storage to stage your tests:

* `index()` - Gets the current index of the store
* `add(User $user)` - Adds a `Tatter\Imposter\Entities\User` object to the store, returning the new index
* `reset()` - Resets the store and the index
* `fake()` - Returns a new `Tatter\Imposter\Entities\User` object using Faker's generated data (note: not added to the store)

For example:
```php

    protected function setUp(): void
    {
        parent::setUp();

        $user = ImposterFactory::fake();
        $user->permissions = ['widgets.create'];
        UserFactory::add($user);

        $this->userId = ImposterFactory::index();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        ImposterFactory::reset();
    }

    public testUserCanCreateWidget()
    {
        $user = service('users')->findById($this->userId);
        service('auth')->login($user);
        ...
```
