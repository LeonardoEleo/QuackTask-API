<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return response()-> json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nome' => 'required',
            'descricao' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Your request is missing data'
            ], 400);
        }

        $task = Task::create($request->all());

        return response()->json([
            'message' => 'task created successfully',
            'Task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json ([
            'message' => 'success',
            'Task' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validated = Validator::make($request->all(), [
            'nome' => 'required|max:255',
            'descricao' => 'required'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'message' => 'Your request is missing data'
            ], 400);
        }

        $task->update($request->all());

        

        return response()->json([
            'message' => 'Task updated successfully',
            'Task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }
    
}
