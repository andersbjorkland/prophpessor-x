<?php

use App\Controller\HomeController;
use App\Middleware\TimerMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = new FrameworkX\App();

$app->get('/', new TimerMiddleware(), new HomeController());

$app->run();