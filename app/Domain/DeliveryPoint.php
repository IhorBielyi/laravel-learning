<?php

namespace App\Domain;

class DeliveryPoint
{
    public function __construct(
        public string $providerType,
        public string $deliveryType,
        public string $address
    ) {}

    public function format(): string
    {
        return "{$this->providerType} [{$this->deliveryType}]: {$this->address}";
    }
}
