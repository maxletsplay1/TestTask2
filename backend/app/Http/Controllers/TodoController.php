<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tasks = Todo::all();
        return response()->json($tasks, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);
        Todo::create($validated);
        return response()->json('Успешно создан', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Todo::find($id);
        if ($task) {
            return response()->json($task, 200);
        } else {
            return response()->json('Не найдено', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }
    public function updateStatus(int $id)
    {
        $task = Todo::find($id);
        if ($task) {
            $newStatus = $task->status == 1 ? 0 : 1;
            $task->update([
                'status' => $newStatus,
                'updated_at' => now(),
            ]);
            return response()->json($task, 200);
        } else {
            return response()->json('Не найдено', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $task = Todo::find($id);
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);
        if ($task) {
            $task->update($validated, [
                'updated_at' => now(),
            ]);
            return response()->json($task, 200);
        } else {
            return response()->json('Не найдено', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Todo::find($id);
        if ($task) {
            $task->delete();
            return response()->json($task, 200);
        } else {
            return response()->json('Не найдено', 404);
        }
    }
}
