<?php

namespace Tatter\Imposter\Entities;

use CodeIgniter\Entity\Entity;
use Tatter\Users\Interfaces\HasGroup;
use Tatter\Users\Interfaces\HasPermission;

class User extends Entity implements HasGroup, HasPermission
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $attributes = [
        'id'          => null,
        'groups'      => '',
        'permissions' => '',
    ];
    protected $casts = [
        'groups'      => 'csv',
        'permissions' => 'csv',
    ];

    //--------------------------------------------------------------------
    // Tatter\Users Interface Methods
    //--------------------------------------------------------------------

    /**
     * Returns the name of the column used to
     * uniquely identify this user, typically 'id'.
     */
    public function getIdentifier(): string
    {
        return 'id';
    }

    /**
     * Returns the value for the identifier,
     * or `null` for "uncreated" users.
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    /**
     * Returns the email address.
     */
    public function getEmail(): ?string
    {
        return $this->attributes['email'] ?? null;
    }

    /**
     * Returns the username.
     */
    public function getUsername(): ?string
    {
        return $this->attributes['username'] ?? null;
    }

    /**
     * Returns the name for this user.
     * If names are stored as parts "first",
     * "middle", "last" they should be
     * concatenated with spaces.
     */
    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    /**
     * Returns whether this user is eligible
     * for authentication.
     */
    public function isActive(): bool
    {
        return $this->attributes['active'] ?? false;
    }

    /**
     * Returns whether this user is a
     * member of the given group.
     */
    public function hasGroup(string $group): bool
    {
        return in_array($group, $this->groups, true);
    }

    /**
     * Returns whether this user has the given permission.
     * Must be comprehensive and cascading (i.e. if auth
     * support global or group permissions those should
     * both be checked in addition to explicit user rights).
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions, true);
    }
}
