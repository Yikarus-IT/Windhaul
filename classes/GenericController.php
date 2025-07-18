<?php

interface GenericController
{
    public function getAll(): array;
    public function getById(int $id): ?array;
}
