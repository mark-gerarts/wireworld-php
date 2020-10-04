<?php

namespace WireWorld;

use League\CLImate\CLImate;
use WireWorld\Exception\WireWorldException;
use WireWorld\Schema\SchemaLoader;
use WireWorld\Game\Game;

final class WireWorld
{
    /**
     * @param string[] $args
     */
    public static function main(array $args): void
    {
        $schemaLoader = new SchemaLoader();
        $climate = new CLImate();
        $climate->arguments->add([
            'mode' => [
                'prefix' => 'm',
                'longPrefix' => 'mode',
                'defaultValue' => 'climenu'
            ],
            'help' => [
                'prefix' => 'h',
                'longPrefix' => 'help',
                'noValue' => true
            ]
        ]);
        $climate->arguments->parse($args);

        if ($climate->arguments->defined('help')) {
            self::printHelp();
            return;
        }

        if (empty($args[0])) {
            echo "Error: no schema provided.\n";
            echo "Usage: ./wireworld path/to/schema.wire\n";
            return;
        }

        try {
            $mode = $climate->arguments->get('mode');
            $grid = $schemaLoader->loadSchema($args[0]);
            $game = new Game($grid);

            self::startWireWorld($game, $mode);
        }
        catch (WireWorldException | \InvalidArgumentException $e) {
            echo $e->getMessage() . "\n";
            return;
        }
    }

    private static function startWireWorld(Game $game, string $mode): void
    {
        switch ($mode) {
            case 'basic':
                (new WireWorldBasic())->startWireWorld($game);
                return;
            case 'climenu':
                (new WireWorldCliMenu())->startWireWorld($game);
                return;
        }

        throw new \InvalidArgumentException('Unsupported mode. Use either "basic" or "climenu"');
    }

    private static function printHelp(): void
    {
        $help = [
            'Wireworld simulator written in PHP.',
            'wireworld [file] [-h] [-m mode]',
            'Available options:',
            '  -h --help: print this help',
            '  -m --mode: climenu (default) or basic',
            'Usage:',
            '  ./wireworld path/to/schema.wire',
            '  ./wireworld path/to/schema.wire --mode=basic',
            ''
        ];

        echo implode("\n", $help);
    }
}
