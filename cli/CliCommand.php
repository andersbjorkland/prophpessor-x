<?php

namespace Cli;

interface CliCommand
{
    public static function getDescription(): string;
    public static function getCommandDescription(string $commandName): string;
}