<?php

namespace App\Domain;

class Order
{
    public function __construct(
        public string $name,
        public int $quantity,
        public float $price,
        public float $discount,
        public DeliveryPoint $deliveryPoint,
    ) {}
}
