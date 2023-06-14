<?php

namespace App\Http\Controllers\Todo;

use App\Models\Tag;
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
        $todos = Todo::query()->latest()->get()->all();
        $tags = Tag::join('todos_tags', 'tags.id', '=', 'todos_tags.tag_id')->get();
        return ['todos' => $todos, 'tags' => $tags];
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->file()) {
            $name = $request->file('file')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('/images', $request->file('file'), rand(0, 50) . $name);
            $path = url('storage/' . $path);
            $todo = Todo::create(
                ['title' => $data['title'], 'imgpath' => $path, 'user_id' => Auth::user()->id]
            );
        } else {
            $todo = Todo::create(
                ['title' => $data['title'], 'user_id' => Auth::user()->id]
            );
        }

        if ($request->tags) {
            $tag_ids = [];
            $tags = explode(",", $data['tags']);
            foreach ($tags as $tag) {
                $tag_ids[] = Tag::firstOrCreate(['title' => $tag])->id;
            }
            $todo->tags()->attach($tag_ids);
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
            $path = Storage::disk('public')->putFileAs('/images', $request->file('file'), rand(0, 50) . $name);
            $path = url('storage/' . $path);
            $todo->update(['title' => $data['title'], 'imgpath' => $path]);
        } else {
            $todo->update(['title' => $data['title']]);
        }
    }

    public function deleteImage(Todo $todo)
    {
        $pos = strpos($todo->imgpath, "images");
        $path = substr($todo->imgpath, $pos);
        Storage::disk('public')->delete($path);
        $todo->update(['imgpath' => '']);
    }

    public function delete(Todo $todo)
    {
        $pos = strpos($todo->imgpath, "images");
        $path = substr($todo->imgpath, $pos);
        Storage::disk('public')->delete($path);
        $todo->delete();
    }
}