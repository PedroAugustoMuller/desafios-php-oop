<?php

namespace Imply\Desafio02\model;

class Review
{
    private float $rating;
    private int $quantity;

    public function __construct(float $rating, float $quantity)
    {
        $this->rating = $rating;
        $this->quantity = $quantity;
    }
    public function getRating(): float
    {
        return $this->rating;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}