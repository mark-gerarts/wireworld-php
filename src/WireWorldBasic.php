<?php

namespace WireWorld;

use WireWorld\Game\Game;

final class WireWorldBasic
{
    public function startWireWorld(Game $game): void
    {
        echo "Starting simulation..\n";

        $renderGame = function (Game $game): void {
            echo "\n" . $game->render() , "\n\n";
        };

        $renderGame($game);

        while (true) {
            $input = readline('[S]tep / [r]estart / [q]uit: ');
            if ($this->isStep($input)) {
                $game->step();
                $renderGame($game);
            }
            elseif ($this->isRestart($input)) {
                $game->restart();
                $renderGame($game);
            }
            elseif ($this->isQuit($input)) {
                break;
            }
        }
    }

    private function isStep(string $input): bool
    {
        return $this->isInputOneOf($input, ['', 's', 'step']);
    }

    private function isRestart(string $input): bool
    {
        return $this->isInputOneOf($input, ['r', 'restart']);
    }

    private function isQuit(string $input): bool
    {
        return $this->isInputOneOf($input, ['q', 'quit']);
    }

    /**
     * @param string $input
     * @param string[] $values
     * @return bool
     */
    private function isInputOneOf(string $input, array $values): bool
    {
        $input = strtolower(trim($input));

        return in_array($input, $values, true);
    }
}
