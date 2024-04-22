<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /* public function index()
    {
        $tasks = Task::all();

        return view('task.index', compact('tasks'));
    } */

    public function create(TodoList $list)
    {
        return view('task.create', compact('list'));
    }

    public function store(TodoList $list, TaskRequest $request)
    {
        $validated = array_merge($request->validated(), [
            'user_id' => Auth::id(),
            'list_id' => $list->id,
        ]);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $validated['image'] = $request->file('image')->store(Auth::id() . '/lists/' . $list->id);
        }

        $task = Task::create($validated);

        // Tags
        if ($validated['tags']) {
            $tags = explode(',', $validated['tags']);

            $task->tags()->delete();

            foreach ($tags as $tag) {
                $tag = Str::lower(trim($tag));
                $task->tags()->create(['tag' => $tag]);
            }
        }

        return redirect()->route('tasks.edit', compact(['list', 'task']));
    }

    /* public function show(Task $task)
    {
        return view('task.show', compact('task'));
    } */

    public function edit(TodoList $list, Task $task)
    {
        $tags = implode(',', array_column($task->tags->toArray(), 'tag'));
        
        return view('task.edit', compact(['list', 'task', 'tags']));
    }

    public function update(Request $request, TodoList $list, Task $task)
    {
        $validator = Validator::make($request->all(), TaskRequest::$rules);
 
        if ($validator->fails()) {
            return response($validator->errors(), 400)
                ->header('Content-Type', 'application/json');
        }

        $validated = array_merge($validator->validated(), [
            'user_id' => Auth::id(),
            'list_id' => $list->id,
        ]);

        // Files
        if ($request->file('image') && $request->file('image')->isValid()) {
            if ($task->image) {
                Storage::delete($task->image);
            }

            $validated['image'] = $request->file('image')->store(Auth::id() . '/lists/' . $list->id);
        }

        if (empty($validated['image']) && $task->image) {
            Storage::delete($task->image);
            $validated['image'] = null;
        }

        // Tags
        if ($validated['tags']) {
            $tags = explode(',', $validated['tags']);

            $task->tags()->delete();

            foreach ($tags as $tag) {
                if (empty(trim($tag))) {
                    continue;
                }
                
                $tag = Str::lower(trim($tag));
                $task->tags()->create(['tag' => $tag]);
            }
        }

        $task->update($validated);

        return response(['message' => 'Список сохранён!'], 200)
            ->header('Content-Type', 'application/json');
    }

    public function destroy(TodoList $list, Task $task)
    {
        $task->delete();

        return redirect()->back();
    }
}
