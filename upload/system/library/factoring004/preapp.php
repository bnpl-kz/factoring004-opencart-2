<?php

namespace BnplPartners\Factoring004Payment;
require_once 'helpers.php';
require_once 'config.php';
use BnplPartners\Factoring004\PreApp\PreAppMessage;

function createPreapp(array $data)
{
    $message = PreAppMessage::createFromArray([
1
    ]);
    return createApi()->preApps->preApp($message);
}
