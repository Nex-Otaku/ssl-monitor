<?php

namespace App\Logger;

class EchoLogger implements Logger
{
    public function write(string $line): void
    {
        echo "{$line}\n";
    }

    public function nextLine(): void
    {
        echo "\n";
    }
}
