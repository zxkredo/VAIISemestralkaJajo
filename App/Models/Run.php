<?php

namespace App\Models;

use App\Core\Model;

class Run extends Model
{
    protected null|int $id = null;
    protected int $organiser_id;
    protected string $name;
    protected string $location;
    protected string $description;
    protected int $capacity;
    protected int $price_in_cents;
    protected string $picture_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getOrganiserId(): int
    {
        return $this->organiser_id;
    }

    public function setOrganiserId(int $organiser_id): void
    {
        $this->organiser_id = $organiser_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getPriceInCents(): int
    {
        return $this->price_in_cents;
    }

    public function setPriceInCents(int $price_in_cents): void
    {
        $this->price_in_cents = $price_in_cents;
    }

    public function getPictureName(): string
    {
        return $this->picture_name;
    }

    public function setPictureName(string $picture_name): void
    {
        $this->picture_name = $picture_name;
    }

}