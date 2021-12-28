<?php

use Tatter\Imposter\Entities\User;
use Tatter\Users\Interfaces\HasGroup;
use Tatter\Users\Interfaces\HasPermission;
use Tatter\Users\Test\EntityTestCase;

/**
 * @internal
 */
final class EntityTest extends EntityTestCase
{
    protected $class = User::class;

    /**
     * Creates the scenario for entities that implement HasGroup
     * to verify the following checks:
     *  - $this->entity->hasGroup('dire') === false
     *  - $this->entity->hasGroup('radiant') === true
     *
     * @param User $entity
     */
    protected function setUpGroups(HasGroup $entity): void
    {
        $entity->groups = ['radiant'];
    }

    /**
     * Creates the scenario for entities that implement HasPermission
     * to verify the following checks:
     *  - $this->entity->hasPermission('creeps.lastHit') === false
     *  - $this->entity->hasPermission('camps.stack') === true
     *
     * @param User $entity
     */
    protected function setUpPermissions(HasPermission $entity): void
    {
        $entity->permissions = ['camps.stack'];
    }
}
