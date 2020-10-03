<?php

namespace WireWorld\Cell;

final class EmptyCell implements Cell
{
    public function step(array $neighbours): Cell
    {
        return $this;
    }
}
