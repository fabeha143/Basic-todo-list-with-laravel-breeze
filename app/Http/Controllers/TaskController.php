<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('todo.index')->with('tasks', Task::where('user_id', auth()->id())->orderBy('id', 'desc')->get());
    // }
    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id());
        
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('id', 'desc')->get();

        return view('todo.index', compact('tasks'));
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
        $request->validate([
            'title' => 'required'
        ]);
        Task::create([
            'title' => $request->input('title'),
            // 'due_date' => $request->input('due_date'),
            'status' => 'pending',
            'user_id' => auth()->id()
        ]);

        return redirect('/todo')
            ->with('message', 'Task Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $task = Task::findOrFail($id);

        // $this->authorize('update', $task); // Optional: Enforces user ownership if using policies

        return view('todo.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {        
            
    
        $task = Task::findOrFail($id);
        // $this->authorize('update', $task);
        if ($task->user_id !== auth()->id()) {
            abort(403); // Or use policy later
        }
        if(isset($request->status)){     
            $task->status = $request->input('status');
        }else{
            $request->validate([
                'title' => 'required'
            ]);
            $task->title = $request->input('title');
            $task->due_date = $request->input('due_date');
        }
        $task->save();
    
        return redirect()->route('todo.index')->with('message', 'Task status updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('id', $id)->firstOrFail();
    
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
    
        $task->delete();
    
        return redirect('/todo')
            ->with('message', 'Task has been deleted');
    }
    
}
