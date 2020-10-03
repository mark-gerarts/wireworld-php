<?php

namespace WireWorld\Cell;

interface Cell
{
    /**
     * @param Cell[] $neighbours
     * @return Cell
     */
    public function step(array $neighbours): Cell;
}
