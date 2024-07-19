<?php

namespace Imply\Desafio02\model;

class Item
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;
    private float $price;
    private string $title;

    public function __construct(int $id, int $orderId, int $productId, int $quantity, float $price, string $title)
    {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->title = $title;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }


    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getValueOfItem(): float
    {
        return $this->price * $this->quantity;
    }

}