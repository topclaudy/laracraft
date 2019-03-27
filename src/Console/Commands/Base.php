<?php

namespace Awobaz\Laracraft\Console\Commands;

use Illuminate\Console\Command;

abstract class Base extends Command
{
    private $foregroundColors = [
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37',
    ];

    private $backgroundColors = [
        'black'      => '40',
        'red'        => '41',
        'green'      => '42',
        'yellow'     => '43',
        'blue'       => '44',
        'magenta'    => '45',
        'cyan'       => '46',
        'light_gray' => '47',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function echo($message, $foregroundColor = 'light_green', $backgroundColor = null)
    {
        $coloredMessage = "";

        // Check if given foreground color found
        if (isset($this->foregroundColors[$foregroundColor])) {
            $coloredMessage .= "\033[".$this->foregroundColors[$foregroundColor]."m";
        }

        // Check if given background color found
        if (isset($this->backgroundColors[$backgroundColor])) {
            $coloredMessage .= "\033[".$this->backgroundColors[$backgroundColor]."m";
        }

        // Add string and end coloring
        $coloredMessage .= $message."\033[0m";

        echo $coloredMessage.PHP_EOL;
    }

    public function infoWithTimestamp($message)
    {
        $timestamp = now('America/New_York')->format('Y-m-d H:i:s');
        echo $timestamp.': '.$message.PHP_EOL;
    }

    public function errorWithTimestamp($message)
    {
        $timestamp = now('America/New_York')->format('Y-m-d H:i:s');
        echo $timestamp.': '.$message.PHP_EOL;
    }
}
