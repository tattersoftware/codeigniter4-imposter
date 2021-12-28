<?php

namespace Tatter\Imposter\Factories;

use Faker\Factory;
use Faker\Generator;
use Tatter\Imposter\Entities\User;
use Tatter\Users\UserEntity;
use Tatter\Users\UserFactory;

/**
 * Imposter User Factory
 *
 * Provides a database-free factory for interacting
 * with Tatter\Users during testing.
 */
class ImposterFactory implements UserFactory
{
    /**
     * Local store of Users.
     *
     * @var array<int|string,User>
     */
    protected static $users = [];

    /**
     * The ID to use when adding a record.
     *
     * @var int
     */
    protected static $index = 0;

    /**
     * Gets the current index.
     */
    public static function index(): int
    {
        return self::$index;
    }

    /**
     * Adds a User to storage.
     *
     * @return int|string Index of the User added
     */
    public static function add(User $user)
    {
        if (null === $id = $user->getId()) {
            do {
                self::$index++;
            } while (array_key_exists(self::$index, self::$users));

            $user->id = $id = self::$index;
        }

        self::$users[$id] = $user;

        return $id;
    }

    /**
     * Resets the storage.
     */
    public static function reset(): void
    {
        self::$index = 0;
        self::$users = [];
    }

    /**
     * Generates a User with faked data.
     */
    public static function fake(?Generator $faker = null): User
    {
        // If no Generator was specified then use the App locale to create one
        if ($faker === null) {
            $faker = Factory::create(config('App')->defaultLocale);
        }

        return new User([
            'name'     => $faker->name,
            'email'    => $faker->email,
            'username' => $faker->userName,
            'active'   => true,
        ]);
    }

    //--------------------------------------------------------------------
    // Tatter\Users Interface Methods
    //--------------------------------------------------------------------

    /**
     * Locates a user by its primary identifier.
     *
     * @param int|string $id
     *
     * @return User|null
     */
    public function findById($id): ?UserEntity
    {
        return self::$users[$id] ?? null;
    }

    /**
     * Locates a user by its email.
     *
     * @return User|null
     */
    public function findByEmail(string $email): ?UserEntity
    {
        foreach (self::$users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Locates a user by its username.
     *
     * @return User|null
     */
    public function findByUsername(string $username): ?UserEntity
    {
        foreach (self::$users as $user) {
            if ($user->getUsername() === $username) {
                return $user;
            }
        }

        return null;
    }
}
