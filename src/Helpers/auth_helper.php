<?php

if (! function_exists('user_id')) {
    /**
     * Returns the ID for the current logged in user.
     *
     * @return int|string|null
     */
    function user_id()
    {
        return service('auth')->id();
    }
}
