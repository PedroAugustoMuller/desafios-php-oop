<?php

namespace Imply\Desafio02\model;

use DateTime;

class Order
{
    private int $id;
    private int $user_id;
    private DateTime $date;

    private string $status;
    private array $items;

    public function __construct(int $id, int $user_id, DateTime $date, $status, array $items)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->date = $date;
        $this->status = $status;
        $this->items = $items;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusEnum(): int
    {
        if ($this->getStatus() == 'On Going') {
            return 1;
        }
        if ($this->getStatus() == 'Completed') {
            return 2;
        }
        return 3;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getValue(): int
    {
        $value = 0;
        foreach ($this->items as $item) {
            $value += $item->getValueOfItem();
        }
        return $value;
    }
}