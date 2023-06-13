<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Todo;

class IndexController extends Controller
{
    public function index()
    {
        return view("todo/index");
    }

    public function send()
    {
        return view("todo/send");
    }

    public function sendTodo()
    {

    }

    public function get()
    {
        $todo = Todo::query()->latest()->get()->all();
        return $todo;
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        if ($request->file()) {
            $name = $request->file('file')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('/images', $request->file('file'), $name);
            $path = url('storage/' . $path);
            Todo::create(
                ['title' => $data['title'], 'imgpath' => $path, 'user_id' => Auth::user()->id]
            );
        } else {
            Todo::create(
                ['title' => $data['title'], 'user_id' => Auth::user()->id]
            );
        }
    }

    public function edit(Todo $todo)
    {
        return view("todo/edit", compact("todo"));
    }

    public function update(UpdateRequest $request, Todo $todo)
    {
        $data = $request->validated();
        if ($request->file()) {
            $name = $request->file('file')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('/images', $request->file('file'), $name);
            $path = url('storage/' . $path);
            $todo->update(['title' => $data['title'], 'imgpath' => $path]);
        } else {
            $todo->update(['title' => $data['title']]);
        }
    }

    public function deleteImage(Todo $todo)
    {
        $todo->update(['imgpath' => '']);
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
        return ["1111111111"];
    }
}