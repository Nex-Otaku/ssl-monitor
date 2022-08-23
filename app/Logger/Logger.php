<?php

namespace App\Logger;

interface Logger
{
    public function write(string $line): void;
    public function nextLine(): void;
}
