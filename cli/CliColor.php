<?php

namespace Cli;

class CliColor
{
    // Opening and closing tags to wrap around the text.
    public const ESCAPE = "\033[";
    public const RESET = '0m';

    // Special codes
    public const BOLD = '1m';
    public const DIM = '2m';
    public const UNDERLINE = '4m';
    public const BLINK = '5m';
    public const REVERSE = '7m';
    public const HIDDEN = '8m';

    // Foreground colors
    public const BLACK = '30m';
    public const RED = '31m';
    public const GREEN = '32m';
    public const YELLOW = '33m';
    public const BLUE = '34m';
    public const MAGENTA = '35m';
    public const CYAN = '36m';
    public const WHITE = '37m';

    // Background colors
    public const BG_BLACK = '40m';
    public const BG_RED = '41m';
    public const BG_GREEN = '42m';
    public const BG_YELLOW = '43m';
    public const BG_BLUE = '44m';
    public const BG_MAGENTA = '45m';
    public const BG_CYAN = '46m';
    public const BG_WHITE = '47m';

    public static function colorize(string $text, string $color): string
    {
        return self::ESCAPE . $color . $text . self::ESCAPE . self::RESET;
    }

    public static function bold(string $text): string
    {
        return self::colorize($text, self::BOLD);
    }

    public static function dim(string $text): string
    {
        return self::colorize($text, self::DIM);
    }

    public static function underline(string $text): string
    {
        return self::colorize($text, self::UNDERLINE);
    }

    public static function blink(string $text): string
    {
        return self::colorize($text, self::BLINK);
    }

    public static function reverse(string $text): string
    {
        return self::colorize($text, self::REVERSE);
    }

    public static function hidden(string $text): string
    {
        return self::colorize($text, self::HIDDEN);
    }

}