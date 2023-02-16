<?php

namespace Kata;

class Game
{
    public Grid $grid;

    public function __construct(
        private readonly int $width,
        private readonly int $height,
        private readonly int $randomize
    )
    {
        $this->grid = new Grid($this->width, $this->height);
        $this->grid->buildRandomGrid($this->randomize);
    }

    public function run(): void
    {
        $newCells = [];

        foreach ($this->grid->cells as $width => $row) {
            foreach ($row as $height => $cell) {
                $aliveCells = $this->countAliveNeighboursCells($width, $height);

                if ($cell) {
                    if ($aliveCells < 2) {
                        $newCells[$width][$height] = false;
                    }

                    if ($aliveCells > 3) {
                        $newCells[$width][$height] = false;
                    }

                    if ($aliveCells ===2 || $aliveCells === 3) {
                        $newCells[$width][$height] = true;
                    }

                } else {
                    if (3 === $aliveCells) {
                        $newCells[$width][$height] = true;
                    } else {
                        $newCells[$width][$height] = false;
                    }
                }
            }
        }

        $newGrid = new Grid($this->width, $this->height);
        $newGrid->buildFromArray($newCells);
        $this->grid = $newGrid;
    }

    private function countAliveNeighboursCells(int $width, int $height): int
    {
        $coordinates = [
            [-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]
        ];

        $count = 0;

        foreach ($coordinates as $position) {
            if (isset($this->grid->cells[$width + $position[0]][$height + $position[1]])
                && $this->grid->cells[$width + $position[0]][$height + $position[1]] === true) {
                $count++;
            }
        }

        return $count;
    }
}