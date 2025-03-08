<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;


class TasksController extends Controller
{
    public function __construct()
    {
        // ログインしていないユーザーをログインページにリダイレクト
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task;
        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:10',
        ]);
        
        $task = new Task;
        $task->user_id = auth()->id();
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id !== auth()->id()) {
            return redirect('/');
        }
        
        return view('tasks.show', [
            'task' => $task,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        
        if ($task->user_id !== auth()->id()) {
            return redirect('/');
        }

        return view('tasks.edit', [
            'task' => $task,
        ]);
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:10',
        ]);

        $task = Task::findOrFail($id);
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        return redirect('/');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id === auth()->id()) {
        $task->delete();
        return redirect('/')->with('success','Delete Successful');
        }

        return redirect('/');
    }

}