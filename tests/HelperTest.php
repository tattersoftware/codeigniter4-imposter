<?php

use Tests\Support\TestCase;

/**
 * @internal
 */
final class HelperTest extends TestCase
{
    public function testUserIdReturnsNull()
    {
		$this->assertNull(user_id());
    }

    public function testUserIdUsesSession()
    {
		session()->set('user_id', 'cashew');

        $this->assertSame('cashew', user_id());
    }

    public function testUserIdUpdatesService()
    {
		session()->set('user_id', 'cashew');

        user_id();

        $this->assertSame('cashew', $this->auth->id());
    }
}
