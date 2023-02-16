<?php

declare(strict_types=1);

namespace Kata;

class Grid
{
    public array $cells = [];

    public function __construct(
        public readonly int $width,
        public readonly int $height
    )
    {
    }

    public function buildRandomGrid($randomize = 1): void
    {
        for ($i = 0; $i < $this->width; $i++) {
            for ($j = 0; $j < $this->height; $j++) {
                $this->cells[$i][$j] = $this->getRandomState($randomize);
            }
        }
    }

    public function buildFromArray(array $cells): void
    {
        $this->cells = $cells;
    }

    public function countLiveCells(): int
    {
        $count = 0;

        foreach ($this->cells as $row) {
            foreach ($row as $cell) {
                if ($cell) {
                    $count++;
                }
            }
        }

        return $count;
    }

    private function getRandomState($randomize): bool
    {
        if ($randomize === 0) {
            return false;
        }

        return !(rand(0, $randomize) === 0);
    }

    public function render(): string
    {
        $output = '';
        foreach ($this->cells as $row) {
            foreach ($row as $cell) {
                if ($cell === true) {
                    $output .= '*';
                } else {
                    $output .= '.';
                }
            }
            $output .= PHP_EOL;
        }

        return $output;
    }
}
