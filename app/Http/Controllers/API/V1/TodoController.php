<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\API\V1\UpdateTodoRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\TodoResource;
use App\Http\Resources\API\V1\TodoCollection;
use App\Http\Requests\API\V1\StoreTodoRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\CustomException;
use App\Interfaces\TodoRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoController extends Controller
{
    public function __construct(private TodoRepositoryInterface $todoRepository) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $todos = $this->todoRepository->getTodos();
            return new TodoCollection($todos);
        } catch (\Exception $err) {
            Log::error('Failed to retrieve todos', [
                'error_message' => $err->getMessage(),
                'stack_trace' => $err->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to retrieve todos',
                'error' => $err->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request,$userId)
    {
        try {
            $todoData = $request->validated();
            $todoData['user_id'] = $userId;

            $todo = $this->todoRepository->createTodo($todoData);
            return new TodoResource($todo);
        } catch (\Exception $err) {
            Log::error('Failed to create todo', [
                'error_message' => $err->getMessage(),
                'stack_trace' => $err->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to create Todo',
                'error' => $err->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $todo = $this->todoRepository->getTodo($id);

            if (!$todo) {
                throw new NotFoundHttpException('Todo not found');
            }

            return new TodoResource($todo->loadMissing('items'));
        } catch (ModelNotFoundException $e) {
            throw new CustomException($e, 'Todo not found', 404);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve todo', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to retrieve todo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, $id)
    {
        try {
            $todo = $this->todoRepository->updateTodo($request->all(), $id);
            return new TodoResource($todo);
        } catch (ModelNotFoundException $e) {
            throw new CustomException($e, 'Todo not found', 404);
        } catch (\Exception $err) {
            Log::error('Failed to update todo', [
                'error_message' => $err->getMessage(),
                'stack_trace' => $err->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to update todo',
                'error' => $err->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $todo = $this->todoRepository->getTodo($id);

            if (!$todo) {
                throw new NotFoundHttpException('Todo not found');
            }

            $todo->softDelete();

            return response()->json([
                'message' => 'Todo deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            throw new CustomException($e, 'Todo not found', 404);
        } catch (\Exception $err) {
            Log::error('Failed to delete Todo', [
                'error_message' => $err->getMessage(),
                'stack_trace' => $err->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to delete Todo',
                'error' => $err->getMessage(),
            ], 500);
        }
    }
}
