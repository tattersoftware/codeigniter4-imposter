<?php

use Tatter\Imposter\Entities\User;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class AuthTest extends TestCase
{
    public function testReturnsNull()
    {
        $this->assertNull($this->auth->user());
        $this->assertNull($this->auth->id());
    }

    public function testLoginSetsUser()
    {
        $user = new User(['id' => 'celery']);

        $this->auth->login($user);

        $result = $this->auth->user();

        $this->assertSame($user, $result);
    }

    public function testLoginCreatesUser()
    {
        $this->auth->login('banana');

        $result = $this->auth->user();

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame('banana', $result->id);
    }

    public function testLoginSetsSession()
    {
        $this->auth->login('banana');

        $this->assertSame('banana', session('logged_in'));
        $this->assertSame('banana', session('user_id'));
    }

    public function testLogoutRemovesUser()
    {
        $this->auth->login('banana');
        $this->auth->logout();

        $result = $this->getPrivateProperty($this->auth, 'user');

        $this->assertNull($result);
    }

    public function testLogoutRemovesSession()
    {
        $this->auth->login('banana');
        $this->auth->logout();

        $this->assertNull(session('logged_in'));
        $this->assertNull(session('user_id'));
    }
}
