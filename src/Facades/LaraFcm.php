<?php

namespace Waheed\LaravelFcmPushNotifications\Facades;

use Illuminate\Support\Facades\Facade;
use Waheed\LaravelFcmPushNotifications\Services\FcmMessage;
class LaraFcm extends Facade
{

    protected static function getFacadeAccessor()
    {
         return 'larafcm';
    }

}
