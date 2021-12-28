<?php

namespace Tests\Support;

use CodeIgniter\Test\CIUnitTestCase;
use Tatter\Imposter\Auth;

/**
 * @internal
 */
abstract class TestCase extends CIUnitTestCase
{
    /**
     * @var Auth
     */
    protected $auth;

    public static function setUpBeforeClass(): void
    {
        helper(['auth']);
    }

    protected function setUp(): void
    {
        $this->resetServices();
        $_SESSION = [];

        parent::setUp();

        $this->auth = new Auth();
    }
}
