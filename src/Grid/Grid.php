<?php

namespace WireWorld\Grid;

use Webmozart\Assert\Assert;
use WireWorld\Cell\Cell;
use WireWorld\Cell\EmptyCell;

final class Grid
{

    /**
     * @var array<array<Cell>>
     */

    private array $grid = [];
    private Dimensions $dimensions;

    public function __construct(Dimensions $dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function setCell(Position $position, Cell $cell): void
    {
        $this->assertValidPosition($position);
        $this->grid[$position->getY()][$position->getX()] = $cell;
    }

    public function getCell(Position $position): Cell
    {
        $this->assertValidPosition($position);
        $cell = $this->grid[$position->getY()][$position->getX()] ?? null;

        return $cell ?: new EmptyCell();
    }

    /**
     * @param Position $position
     * @return Cell[]
     */
    public function getNeighboursOf(Position $position): array
    {
        $this->assertValidPosition($position);
        $neighbouringPositions = $position->getNeighbours();
        $neighbouringPositions = array_filter(
          $neighbouringPositions,
          [$this, 'isValidPosition']
        );

        return array_map([$this, 'getCell'], $neighbouringPositions);
    }

    private function assertValidPosition(Position $position): void
    {
        Assert::true($this->isValidPosition($position));
    }

    private function isValidPosition(Position $position): bool
    {
        return $position->getX() >= 0
          && $position->getX() < $this->dimensions->getWidth()
          && $position->getY() >= 0
          && $position->getY() < $this->dimensions->getHeight();
    }
}
