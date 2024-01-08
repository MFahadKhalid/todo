<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Validator;

class TodoController extends Controller
{
    public function index(){
        $data['todos'] = Todo::where('user_id' , auth()->user()->id)->get();
        $view = view('pages.todo',$data);
        return response(['success' => true, 'data' => $view->render()]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'description' => 'max:8000',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        }else{
            $todo = new Todo;
            $todo->user_id = auth()->user()->id;
            $todo->title = $request->input('title');
            $todo->description = $request->input('description');
            if($request->file('image')){
                $image = $request->file('image');
                $imageName = 'todo' . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move('upload/todo',$imageName);
                $todo->image = $imageName;
            }
            $todo->save();
            return response()->json(['status' => 200 , 'message' => 'Task created']);
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
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'description' => 'max:8000',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        }else{
            $todo = Todo::find($id);
            if($todo){
                $todo->user_id = auth()->user()->id;
                $todo->title = $request->input('title');
                $todo->description = $request->input('description');
                $imageData = Todo::where('id',$id)->firstorfail();
                if($request->file('image')){
                    $image = $request->file('image');
                    $imageName = 'todo' . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $image->move('upload/todo',$imageName);
                    $todo->image = $imageName;
                }
                else{
                    $imageName = $imageData->image;
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
