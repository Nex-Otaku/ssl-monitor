<?php

namespace App\Notification\Exception;

class FailedToSendNotification extends \RuntimeException
{
    public static function noCodeApiFailed(int $httpErrorCode): self
    {
        return new self("NoCodeApi failed to execute API request. HTTP status code: {$httpErrorCode}");
    }
}