<?php

namespace Imply\Desafio02\model;

class Product
{
    private int $id;
    private string $title;
    private float $price;
    private string $description;
    private string $category;
    private string $image;
    private Review $review;

    public function __construct(int $id, string $title, string $price, string $description, string $category, string $image, Review $review)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->category = $category;
        $this->image = $image;
        $this->review = $review;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImage(): string
    {
        return $this->image;
    }
    public function getReview(): Review
    {
        return $this->review;
    }
    public function getReviewRate(): float
    {
        return $this->review->getRate();
    }
}