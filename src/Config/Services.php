<?php

namespace Tatter\Imposter\Config;

use Config\Services as BaseService;
use Tatter\Imposter\Auth;

class Services extends BaseService
{
    public static function auth(bool $getShared = true): Auth
    {
        if ($getShared) {
            return self::getSharedInstance('auth');
        }

        return new Auth();
    }
}
