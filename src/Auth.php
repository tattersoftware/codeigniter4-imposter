<?php

namespace Tatter\Imposter;

use CodeIgniter\Events\Events;
use Tatter\Imposter\Entities\User;

class Auth
{
    /**
     * @var User|null
     */
    protected $user;

    /**
     * Creates a User with the given ID and logs it in.
     *
     * @param int|string|User $user
     */
    public function login($user): void
    {
        if (is_int($user) || is_string($user)) {
            $user = new User(['id' => $user]);
        }

        $this->user = $user;

        session()->set('logged_in', $this->user->id);
        session()->set('user_id', $this->user->id);

        Events::trigger('login', $this->user);
    }

    /**
     * Logs out any users.
     */
    public function logout(): void
    {
        if ($this->user !== null) {
            Events::trigger('logout', $this->user);
            $this->user = null;
        }

        session()->remove(['logged_in', 'user_id']);
    }

    /**
     * Returns the current user's id, if logged in.
     *
     * @return int|string|null
     */
    public function id()
    {
        return ($user = $this->user())
            ? $user->id
            : null;
    }

    /**
     * Returns the current user, if logged in.
     */
    public function user(): ?User
    {
        // If there is no login then check the Session
        if ($this->user === null) {
            if ($id = session('logged_in')) {
                $this->login($id);
            } elseif ($id = session('user_id')) {
                $this->login($id);
            }
        }

        return $this->user;
    }
}
