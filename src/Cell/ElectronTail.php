<?php

namespace WireWorld\Cell;

final class ElectronTail implements Cell
{
    public function step(array $neighbours): Cell
    {
        return new Connector();
    }
}
