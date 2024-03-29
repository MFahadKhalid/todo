<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use DataTables;
use Validator;
use File;

class TodoController extends Controller
{
    public function fetch(Request $request)
    {
        $todos = Todo::where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->paginate(5);
        return response()->json($todos);
    }
    public function store(Request $request){
        $validator = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|mimes:png,jpg,jpeg',
            'description' => 'max:8000',
        ]);
        if(auth()->user()->id){
            $todo = new Todo;
            $todo->user_id = auth()->user()->id;
            $todo->title = $request->input('title');
            $todo->description = $request->input('description');
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = 'todo' . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('storage/upload/todo',$imageName);
                $todo->image = $imageName;
            }
            $todo->save();
            return response()->json(['status' => 200 , 'message' => 'Task created']);
        }
    }
    public function view($id){
        $todos = Todo::find($id);
        if($todos){
            return response()->json(['status' == 200 , 'todo' => $todos]);
        }else{
            return response()->json(['status' == 404 , 'todo' => '404 not found']);
        }
    }
    public function edit($id){
        $todo = Todo::find($id);
        if($todo){
            return response()->json(['status' == 200 , 'todo' => $todo]);
        }else{
            return response()->json(['status' == 404 , 'todo' => '404 not found']);
        }
    }
    public function update(Request $request , $id){
        $validator = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image',
            'description' => 'max:8000',
        ]);
        if(auth()->user()->id){
            $todo = Todo::find($id);
            if($todo){
                $todo->user_id = auth()->user()->id;
                $todo->title = $request->input('title');
                $todo->description = $request->input('description');

                if ($request->hasFile('image')) {
                    $imageData = Todo::where('id',$id)->firstorfail();
                    $path = 'storage/upload/todo/'.$imageData->image;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                    $image = $request->file('image');
                    $imageName = 'todo' . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $image->move('storage/upload/todo',$imageName);
                    $todo->image = $imageName;
                }

                $todo->update();
                return response()->json(['status' => 200 , 'message' => 'Task updated']);
            }else{
                return response()->json(['status' => 404 , 'message' => '404 not found']);
            }
        }
    }
    public function delete($id){
        $todo = Todo::find($id);
        $path = 'storage/upload/todo/'.$todo->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $todo->delete();
        return response()->json(['status' => 200 , 'message' => 'Task deleted']);
    }
    public function TaskCompleted(Request $request , $id){
        $todo = Todo::find($id);
        if($todo){
            $todo->status = '1';
            $todo->update();
            return response()->json(['status' => 200 , 'message' => 'Task completed']);
        }else{
            return response()->json(['status' => 404 , 'message' => '404 not found']);
        }
    }
}
