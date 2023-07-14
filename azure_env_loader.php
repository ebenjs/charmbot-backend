<?php

use Symfony\Component\Dotenv\Dotenv;

// Load Azure environment variables
$azureEnvFile = $_SERVER['HOME'] . '/.env';
if (file_exists($azureEnvFile)) {
    (new Dotenv())->usePutenv(true)->load($azureEnvFile);
}

// Load local environment variables
$localEnvFile = __DIR__ . '/.env.local';
if (file_exists($localEnvFile)) {
    (new Dotenv())->usePutenv(true)->load($localEnvFile);
}
