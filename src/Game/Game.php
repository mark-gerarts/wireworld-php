<?php

namespace WireWorld\Game;

use WireWorld\Grid\Grid;
use WireWorld\Grid\Position;
use WireWorld\UI\GridRenderer;

final class Game
{
    private Grid $originalGrid;
    private Grid $grid;
    private GridRenderer $gridRenderer;

    public function __construct(Grid $grid)
    {
        $this->gridRenderer = new GridRenderer();
        $this->originalGrid = $grid;
        $this->grid = $grid;
    }

    public function step(): void
    {
        $width = $this->grid->getDimensions()->getWidth();
        $height = $this->grid->getDimensions()->getHeight();
        $newGrid = new Grid($this->grid->getDimensions());

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $position = new Position($x, $y);
                $cell = $this->grid->getCell($position);
                $neighbours = $this->grid->getNeighboursOf($position);
                $newCell = $cell->step($neighbours);
                $newGrid->setCell($position, $newCell);
            }
        }

        $this->grid = $newGrid;
    }

    public function render(): string
    {
        return $this->gridRenderer->render($this->grid);
    }

    public function restart(): void
    {
        $this->grid = $this->originalGrid;
    }
}
