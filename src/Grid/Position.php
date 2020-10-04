<?php

namespace WireWorld\Grid;

final class Position
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @return Position[]
     */
    public function getNeighbours(): array
    {
        $increments = [-1, 0 , 1];

        $neighbours = [];
        foreach ($increments as $incrementX) {
            foreach ($increments as $incrementY) {
                if ($incrementX === 0 && $incrementY === 0) {
                    continue;
                }

                $neighbours[] = new Position(
                  $this->x + $incrementX,
                  $this->y + $incrementY
                );
            }
        }

        return $neighbours;
    }
}
