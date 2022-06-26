<?php

use Cli\CliColor as Color;
use React\Promise\PromiseInterface;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

echo Color::bold(
        Color::colorize("Welcome to prophpessor-x\n", Color::GREEN)
);

$args = $_SERVER['argv'];
$commands = [
    'db:init' =>
        [
            'description' => \Cli\CliDB::getCommandDescription('init'),
            'cmd' => fn() => \Cli\CliDB::init()
        ]
];

if (count($args) > 1) {
    $result = match ($args[1]) {
        '--help' => "Available commands: \n" . getCommandList($commands),
        'db:init' => $commands['db:init']['cmd'](),
    };

    if (is_string($result)) {
        echo $result;
    }

}

echo "\n";


function getCommandList(array $commands): string
{
    $list = "";

    foreach ($commands as $command => $arr) {
        $list .= Color::bold($command) . "    : " . $arr['description'] . "\n";
    }

    return $list;
}