<?php

namespace WireWorld\Cell;

final class Connector implements Cell
{
    public function step(array $neighbours): Cell
    {
        $numberOfNeighbouringHeads = $this->getNumberOfNeighbouringHeads($neighbours);
        if ($numberOfNeighbouringHeads === 1 || $numberOfNeighbouringHeads === 2) {
            return new ElectronHead();
        }

        return $this;
    }

    /**
     * @param Cell[] $neigbours
     * @return int
     */
    private function getNumberOfNeighbouringHeads(array $neigbours): int
    {
        $numberOfHeads = 0;
        foreach ($neigbours as $neigbour) {
            if ($neigbour instanceof ElectronHead) {
                $numberOfHeads++;
            }
        }

        return $numberOfHeads;
    }
}
