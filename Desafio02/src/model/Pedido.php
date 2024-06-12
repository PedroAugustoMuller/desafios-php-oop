<?php

namespace Imply\Desafio02\model;

use DateTime;

class Pedido
{
    private int $id;
    private int $user_id;
    private DateTime $data;
    private array $items;

    public function __construct(int $id, int $user_id, DateTime $data, array $items)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->data = $data;
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

    public function getData(): DateTime
    {
        return $this->data;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getValue()
    {
        $value = 0;
        foreach ($this->items as $item)
        {
            $value += $item->getValueOfItem();
        }
        return $value;
    }
}