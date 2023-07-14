<?php

use Symfony\Component\Dotenv\Dotenv;

// Load Azure environment variables
// Load local environment variables
$localEnvFile = __DIR__ . '/.env.local';
if (file_exists($localEnvFile)) {
    (new Dotenv())->usePutenv(true)->load($localEnvFile);
}

