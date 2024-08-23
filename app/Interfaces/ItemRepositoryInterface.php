<?php

namespace App\Interfaces;

interface ItemRepositoryInterface
{
    public function getItems($todoID);

    public function getItem($id);

    public function createItem(array $body);

    public function updateItem(array $body,$todoID, $id);
}