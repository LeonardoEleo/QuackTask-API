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

        return response()-> json([
            'message' => 'tasks retrieved successfully',
            'data' => $tasks
        ]);
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
            'data' => $task
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
            'data' => $task
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $Task)
    {
        $task = Task::find($Task->id);

        if(!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        $request->nome ? $task->nome = $request->nome: null;
        $request->descricao ? $task->descricao = $request->descricao: null;
        $request->data_conclusao ? $task->data_conclusao = $request->data_conclusao: null;
        if (isset($request->status)) {
            $task->status = $request->status;
        }

        $task->update();
        

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task
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

