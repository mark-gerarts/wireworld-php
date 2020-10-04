<?php

namespace WireWorld\UI;

use WireWorld\Cell\Cell;
use WireWorld\Cell\Connector;
use WireWorld\Cell\ElectronHead;
use WireWorld\Cell\ElectronTail;
use WireWorld\Cell\EmptyCell;
use WireWorld\Grid\Grid;
use WireWorld\Grid\Position;

final class GridRenderer
{
    public function render(Grid $grid): string
    {
        $width = $grid->getDimensions()->getWidth();
        $height = $grid->getDimensions()->getHeight();
        $output = [];

        for ($y = 0; $y < $height; $y++) {
            $line = [];

            for ($x = 0; $x < $width; $x++) {
                $position = new Position($x, $y);
                $cell = $grid->getCell($position);
                $line[] = $this->renderCell($cell);
            }

            $output[] = $line;
        }

        $output = array_map(
          fn (array $line) => implode('', $line),
          $output
        );

        return implode("\n", $output);
    }

    private function renderCell(Cell $cell): string
    {
        if ($cell instanceof Connector) {
            return "░";
        }
        if ($cell instanceof ElectronHead) {
            return "█";
        }
        if ($cell instanceof ElectronTail) {
            return "▒";
        }
        if ($cell instanceof EmptyCell) {
            return ' ';
        }

        return '';
    }
}
