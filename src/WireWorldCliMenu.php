<?php

namespace WireWorld;

use PhpSchool\CliMenu\Builder\CliMenuBuilder;
use PhpSchool\CliMenu\Builder\SplitItemBuilder;
use PhpSchool\CliMenu\CliMenu;
use PhpSchool\CliMenu\MenuItem\AsciiArtItem;
use PhpSchool\CliMenu\Style\DefaultStyle;
use PhpSchool\CliMenu\Style\SelectableStyle;
use WireWorld\Game\Game;

final class WireWorldCliMenu
{
    public function startWireWorld(Game $game): void
    {
        global $argv;
        $filepath = $argv[1];

        $exit = function (CliMenu $menu): void {
            $menu->close();
        };

        $redraw = function (CliMenu $menu) use ($game): void {
            $items = $menu->getItems();
            foreach ($items as $item) {
                $menu->removeItem($item);
            }
            $items[2] = new AsciiArtItem($game->render());
            $menu->addItems($items);
            $menu->redraw();
        };

        $stepAndRedraw = function (CliMenu $menu) use ($game, $redraw): void {
            $game->step();
            $redraw($menu);
        };

        $restart = function (CliMenu $menu) use ($game, $redraw): void {
            $game->restart();
            $redraw($menu);
        };

        $builder = (new CliMenuBuilder)
            ->disableDefaultItems()
            ->setTitle('Wireworld - ' . basename($filepath))
            ->setTitleSeparator('─')
            ->addLineBreak()
            ->addLineBreak()
            ->setBorder(0)
            ->setMargin(2)
            ->setPadding(2, 5)
            ->setDefaultStyle(new DefaultStyle())
            ->setForegroundColour('white')
            ->setBackgroundColour('black')
            ->modifySelectableStyle(function (SelectableStyle $style): void {
                $style
                    ->setUnselectedMarker('')
                    ->setSelectedMarker('');
            })
            ->addAsciiArt($game->render())
            ->addLineBreak()
            ->addLineBreak()
            ->addSplitItem(function (SplitItemBuilder $b) use ($stepAndRedraw, $restart, $exit): void {
                $b->addItem('S: Step', $stepAndRedraw);
                $b->addItem('R: Restart', $restart);
                $b->addItem('Q: Quit', $exit);
            })
            ->setMarginAuto();

        $menu = $builder->build();
        $menu->addCustomControlMapping('s', $stepAndRedraw);
        $menu->addCustomControlMapping('r', $restart);
        $menu->addCustomControlMapping('q', $exit);

        $menu->open();
    }
}
