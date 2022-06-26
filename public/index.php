<?php

use App\Controller\HomeController;
use App\Middleware\TimerMiddleware;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

$app = new FrameworkX\App();

$app->get('/', new HomeController());

$app->run();