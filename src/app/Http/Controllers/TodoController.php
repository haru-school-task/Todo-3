<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Category;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')
            ->where('user_id', Auth::id())
            ->get();
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }

    public function store(TodoRequest $request)
    {
        $todoData = $request->only(['category_id', 'content']);
        $todoData['user_id'] = Auth::id();

        Todo::create($todoData);

        return redirect('/')->with('message', 'Todoを作成しました');
    }

    public function update(TodoRequest $request)
    {
        $todo = $request->only(['content']);
        Todo::where('user_id', Auth::id())->find($request->id)->update($todo);

        return redirect('/')->with('message', 'Todoを更新しました');
    }

    public function destroy(Request $request)
    {
        Todo::where('user_id', Auth::id())->find($request->id)->delete();
        return redirect('/')->with('message', 'Todoを削除しました');
    }

    public function search(Request $request)
    {
        $todos = Todo::with('category')
            ->where('user_id', Auth::id())
            ->CategorySearch($request->category_id)
            ->KeywordSearch($request->keyword)
            ->get();
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }
}
