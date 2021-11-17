<?php

namespace Tatter\Imposter\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $attributes = [
        'id' => null,
    ];
}
