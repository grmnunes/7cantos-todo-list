<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskFormRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    public function store(TaskFormRequest $request)
    {
        try {
            Task::create($request->except('_token'));

            return response()->json([
                'data' => [
                    'success' => true,
                    'message' => 'Tarefa adicionada com sucesso.',
                ],
            ]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage().'|'.$e->getFile().':'.$e->getLine();
            Log::error($errorMessage);

            return response()->json([
                'data' => [
                    'success' => false,
                    'message' => 'Houve um erro ao adicionar a tarefa.',
                    'error_message' => $errorMessage,
                ],
            ], 500);
        }
    }

    public function update(TaskFormRequest $request, string $id)
    {
        try {

            $task = Task::findOrFail($id);
            $task->update($request->except('_token'));

            return response()->json([
                'data' => [
                    'success' => true,
                    'message' => 'Alterações realizadas com sucesso.',
                ],
            ]);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage().'|'.$e->getFile().':'.$e->getLine();
            Log::error($errorMessage);

            return response()->json([
                'data' => [
                    'success' => false,
                    'message' => 'Houve um erro ao realizar as alterações.',
                    'error_message' => $errorMessage,
                ],
            ], 400);
        }
    }

    public function destroy(string $id)
    {
        try {

            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json([
                'data' => [
                    'success' => true,
                    'message' => 'Tarefa deletada com sucesso.',
                ],
            ]);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage().'|'.$e->getFile().':'.$e->getLine();
            Log::error($errorMessage);

            return response()->json([
                'data' => [
                    'success' => false,
                    'message' => 'Houve um erro ao deletar a tarefa.',
                    'error_message' => $errorMessage,
                ],
            ], 400);
        }
    }

    public function toggleCompletedStatus(string $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            if ($task->status) {
                $task->status = false;
                $task->finished_at = null;
                $task->save();

                return response()->json([], 204);
            }

            $task->status = true;
            $task->finished_at = now();
            $task->save();

            return response()->json([], 204);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage().'|'.$e->getFile().':'.$e->getLine();
            Log::error($errorMessage);

            return response()->json([
                'data' => [
                    'success' => false,
                    'message' => 'Houve um erro ao atualizar o status.',
                    'error_message' => $errorMessage,
                ],
            ], 400);
        }
    }
}
