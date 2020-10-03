<?php

namespace WireWorld\Cell;

final class ElectronHead implements Cell
{
    public function step(array $neighbours): Cell
    {
        return new ElectronTail();
    }

}
