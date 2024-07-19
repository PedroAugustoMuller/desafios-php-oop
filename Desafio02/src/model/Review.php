<?php

namespace Imply\Desafio02\model;

class Review
{
    private int $id;
    private float $rate;
    private int $count;

    public function __construct(int $id, float $rate, float $count)
    {
        $this->id = $id;
        $this->rate = $rate;
        $this->count = $count;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}