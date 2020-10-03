<?php

namespace WireWorld;

use WireWorld\Exception\WireWorldException;
use WireWorld\Schema\SchemaLoader;
use WireWorld\Game\Game;

final class WireWorld
{
    private SchemaLoader $schemaLoader;

    public function __construct()
    {
        $this->schemaLoader = new SchemaLoader();
    }

    public function main(array $args): void
    {
        if (empty($args[0])) {
            echo "Error: no schema provided.\n";
            echo "Usage: ./wireworld path/to/schema.wir\n";
            return;
        }

        try {
            $this->startWireWorld($args);
        }
        catch (WireWorldException $e) {
            echo $e->getMessage() . "\n";
            return;
        }
    }

    private function startWireWorld(array $args): void
    {
        $grid = $this->schemaLoader->loadSchema($args[0]);
        $game = new Game($grid);

        echo "Starting simulation..\n";

        $game->render();
        while (true) {
            $input = readline('Advance one step? [Y/n]: ');
            if ($this->isTruthy($input)) {
                $game->step();
                $game->render();
            }
            else {
                echo "Quitting simulation. Bye!\n";
                break;
            }
        }
    }

    private function isTruthy(string $input): bool
    {
        $input = trim($input);
        $truthyValues = ['', 'y', 'Y', 'yes', 'Yes', '1'];

        return in_array($input, $truthyValues, true);
    }
}
