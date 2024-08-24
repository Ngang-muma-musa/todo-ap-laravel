<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\API\V1\UpdateItemRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreItemRequest;
use App\Http\Resources\API\V1\ItemResource;
use App\Http\Resources\API\V1\ItemCollection;
use Illuminate\Validation\ValidationException;
use App\Exceptions\CustomException;
use App\Interfaces\ItemRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemController extends Controller
{
    public function __construct(private ItemRepositoryInterface $itemRepository){}
    /**
     * Display a listing of the resource.
     */
    public function index($todoId)
    {
        try {
            $items = $this->itemRepository->getItems($todoId);
  
            return new ItemCollection($items);
    
        } catch (\Exception $e) {
            // Log the error with detailed information
            throw new CustomException($e, 'Failed to get items', 500); 
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request, $todoId)
    {
        try {
            // Merge the todo_id into the request data
            $itemData = $request->validated();
            $itemData['todo_id'] = $todoId;
    
            $item = $this->itemRepository->createItem($itemData);
    
            Log::info('Item created successfully', [
                'item_id' => $item->id,
                'todo_id' => $todoId,
                'item_data' => $itemData
            ]);
    
            return response()->json([
                'message' => 'Item created successfully',
                'item' => new ItemResource($item),
            ], 201); 
    
        } catch (ValidationException $e) {
            throw new CustomException($e, 'Validation failed.', 400);
        } catch (\Exception $e) {
            throw new CustomException($e, 'Failed to create item', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $item = $this->itemRepository->getItem($id);

            $itemResource = new ItemResource($item);
    
            Log::info('Item retrieved successfully', [
                'item_id' => $item->id,
            ]);
    
            return response()->json($itemResource, 200);
    
        } catch (ModelNotFoundException $e) {
            throw new CustomException($e, 'Item not found', 404);
        } catch (\Exception $e) {
            throw new CustomException($e, 'Failed to retrieve item', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, $todoId, $id)
    {
        try {
            $item = $this->itemRepository->updateItem($request->validated(), $todoId, $id);

            if (!$item) {
                throw new ModelNotFoundException('Item not found');
            }

            return response()->json([
                'message' => 'Item updated successfully',
                'item' => new ItemResource($item),
            ], 200);
        } catch (ValidationException $e) {
            throw new CustomException($e, 'Validation failed', 422);
        } catch (ModelNotFoundException $e) {
            throw new CustomException($e, 'Item not found', 404);
        } catch (\Exception $e) {
            throw new CustomException($e, 'Failed to update item', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $item = $this->itemRepository->getItem($id);

            if (!$item) {
                throw new ModelNotFoundException('Item not found');
            }

            $item->delete(); 
    
            Log::info('Item soft deleted successfully', [
                'item_id' => $item->id,
            ]);
    
            return response()->json([
                'message' => 'Item soft deleted successfully',
            ], 200);
    
        } catch (ModelNotFoundException $e) {
            throw new CustomException($e, 'Item not found', 404);
        } catch (\Exception $e) {
            throw new CustomException($e, 'Failed to delete item', 500);
        }
    }
}
