<?php

namespace WireWorld\Schema;

use Symfony\Component\Filesystem\Filesystem;
use WireWorld\Exception\SchemaException;
use WireWorld\Grid\Dimensions;
use WireWorld\Grid\Grid;
use WireWorld\Grid\Position;

final class SchemaLoader
{
    private Filesystem $fileSystem;
    private CellParser $cellParser;

    public function __construct()
    {
        $this->fileSystem = new Filesystem();
        $this->cellParser = new CellParser();
    }

    public function loadSchema(string $filepath): Grid
    {
        if (!$this->fileSystem->exists($filepath)) {
            throw new SchemaException('Could not open ' . $filepath);
        }

        $lines = $this->readFile($filepath);
        $grid = $this->parseLines($lines);

        return $grid;
    }

    private function padLines(array $lines): array
    {
        $maxWidth = $this->getMaxWidth($lines);

        return array_map(
          fn (string $line): string => str_pad($line, $maxWidth),
          $lines
        );
    }

    private function parseLines(array $lines): Grid
    {
        $dimensions = $this->getDimensions($lines);
        $grid = new Grid($dimensions);

        foreach ($lines as $y => $line) {
            foreach (str_split($line) as $x => $char) {
                $position = new Position($x, $y);
                $cell = $this->cellParser->parseChar($char);
                $grid->setCell($position, $cell);
            }
        }

        return $grid;
    }

    private function getDimensions(array $lines): Dimensions
    {
        return new Dimensions(
          strlen($lines[0]),
          count($lines)
        );
    }

    private function readFile(string $filepath): array
    {
        $handle = fopen($filepath, 'rb');
        $lines = [];

        while (($line = fgets($handle)) !== false) {
            $line = trim($line, "\n");
            $lines[] = $line;
        }

        if (empty(array_filter($lines))) {
            throw new SchemaException('Empty schema provided');
        }

        return $this->padLines($lines);
    }

    private function getMaxWidth(array $lines): int
    {
        $width = 0;
        foreach ($lines as $line) {
            $lineLength = strlen($line);
            if ($lineLength > $width) {
                $width = $lineLength;
            }
        }

        return $width;
    }
}
