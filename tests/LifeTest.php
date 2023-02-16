<?php

declare(strict_types=1);

namespace Test;

use Kata\Game;
use Kata\Grid;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../vendor/autoload.php';

class LifeTest extends TestCase
{
    public function testBuildGrid(): void
    {
        $grid = new Grid(25, 25);

        $grid->buildRandomGrid();
        $this->assertCount(25, $grid->cells);
    }

    public function testBuildFullDeadGrid(): void
    {
        $grid = new Grid(25, 25);

        $grid->buildRandomGrid(0);

        $this->assertNotContains(true, $grid->cells);
        $this->assertEquals(0, $grid->countLiveCells());
    }

    public function testPrintGrid(): void
    {
        $grid = new Grid(5, 5);

        $grid->buildRandomGrid(0);

        $this->assertEquals(<<<GRID
.....
.....
.....
.....
.....

GRID,
            $grid->render()
);
    }

    public function testCreateGameWithAssociatedGrid(): void
    {
        $game = new Game(8, 4, 0);
        $this->assertInstanceOf(Grid::class, $game->grid);

        $game->grid->buildFromArray([
            [false, false, false, false, false, false, false, false],
            [false, false, false, false, true, false, false, false],
            [false, false, false, true, true, false, false, false],
            [false, false, false, false, false, false, false, false],
        ]);

        $this->assertEquals(<<<GRID
........
....*...
...**...
........

GRID,
            $game->grid->render()
        );

        $game->run();

        $this->assertEquals(<<<GRID
........
...**...
...**...
........

GRID,
            $game->grid->render()
        );

    }

}
