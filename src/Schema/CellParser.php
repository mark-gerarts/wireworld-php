<?php

namespace WireWorld\Schema;

use WireWorld\Cell\Cell;
use WireWorld\Cell\Connector;
use WireWorld\Cell\ElectronHead;
use WireWorld\Cell\ElectronTail;
use WireWorld\Cell\EmptyCell;
use WireWorld\Exception\SchemaException;

final class CellParser
{
    private const CHAR_EMPTY = ' ';
    private const CHAR_HEAD = 'H';
    private const CHAR_TAIL = 't';
    private const CHAR_CONNECTOR = '#';

    public function parseChar(string $char): Cell
    {
        switch ($char) {
            case self::CHAR_EMPTY:
                return new EmptyCell();
            case self::CHAR_HEAD:
                return new ElectronHead();
            case self::CHAR_TAIL:
                return new ElectronTail();
            case self::CHAR_CONNECTOR:
                return new Connector();
        }

        $message = [
            "Invalid character encountered in schema: {$char}. The following characters are valid:",
            "Empty cell: space",
            "Electron head: " . self::CHAR_HEAD,
            "Electron tail: " . self::CHAR_TAIL,
            "Connector: " . self::CHAR_CONNECTOR
        ];

        throw new SchemaException(implode("\n", $message));
    }
}
