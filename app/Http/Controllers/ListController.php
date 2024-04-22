<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Http\Requests\ListRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    private function checkAuthor($list)
    {
        if ($list->user_id != Auth::id()) {
            return false;
        }

        return true;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = TodoList::where('user_id', Auth::id())->get();

        return view('list.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListRequest $request)
    {
        $list = TodoList::create(array_merge($request->validated(), ['user_id' => Auth::id()]));

        return redirect()->route('lists.edit', ['list' => $list]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, TodoList $list)
    {
        if (!$this->checkAuthor($list)) {
            return redirect('/');
        }

        if ($request->has('search')) {
            $search = explode(',', $request->search);

            foreach ($list->tasks as $key => $task) {
                $tags = array_column($task->tags->toArray(), 'tag');
                $intersect = array_uintersect($search, $tags, "strcasecmp");

                if (empty(array_uintersect($search, $tags, "strcasecmp"))) {
                    unset($list->tasks[$key]);
                }
            }
        }

        return view('list.show', compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TodoList $list)
    {
        if (!$this->checkAuthor($list)) {
            return redirect('/');
        }
        
        return view('list.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TodoList $list)
    {
        $validator = Validator::make($request->all(), ListRequest::$rules);
 
        if ($validator->fails()) {
            return response($validator->errors(), 400)
                ->header('Content-Type', 'application/json');
        }
 
        $list->update($validator->validated());

        return response(['message' => 'Список сохранён!'], 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TodoList $list)
    {
        $list->delete();

        return redirect()->back();
    }
}
