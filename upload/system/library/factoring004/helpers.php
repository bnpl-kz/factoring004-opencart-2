<?php

namespace BnplPartners\Factoring004Payment;

require_once __DIR__.'vendor/autoload.php';
require_once 'config.php';

use BnplPartners\Factoring004\Api;
use BnplPartners\Factoring004\Auth\BearerTokenAuth;
use BnplPartners\Factoring004\OAuth\CacheOAuthTokenManager;
use BnplPartners\Factoring004\OAuth\OAuthTokenManager;

function createApi(): Api
{

}
