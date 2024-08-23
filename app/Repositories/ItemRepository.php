<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface
{
    public function getItems($todoID)
    {
        return Item::where('todo_id', $todoID)->get();
    }

    public function getItem($id)
    {
        return Item::find($id);
    }

    public function createItem(array $body)
    {
        return Item::create($body);
    }

    public function updateItem(array $body, $groupID, $id)
    {
        $item = Item::where('todo_id', $groupID)->find($id);
        if ($item) {
            $item->update($body);
            return $item;
        }
        
        return null;
    }
}
