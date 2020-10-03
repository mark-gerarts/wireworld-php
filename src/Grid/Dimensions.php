<?php

namespace WireWorld\Grid;

use Webmozart\Assert\Assert;

final class Dimensions
{
    private int $width;
    private int $height;

    public function __construct(int $width, int $height)
    {
        Assert::greaterThan($width, 0);
        Assert::greaterThan($height, 0);

        $this->width = $width;
        $this->height = $height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }
}
