<?php

namespace App\Common\Logger;

class NullLogger implements Logger
{
    public function write(string $line): void
    {
        // Ничего не делаем.
    }

    public function nextLine(): void
    {
        // Ничего не делаем.
    }
}