<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\Request;
use Validator;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
           }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $rules = [
            'title' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                'errors' => $validator->errors()->all(),
            ));
        } else {
            // $data = $request->except("_token", "_method");
            $user_store = Todo::create([
                'user_id' => auth()->user()->id,
                'title'=> $request->title,
                'status' => 'pending',
            ]);
            if($user_store){
                return response()->json($user_store);
            }
            return 2;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $user = auth()->user();
        $todo = Todo::where('user_id', $user->id )->findOrFail($todo->id);
        $todo->update([
            'status' => 'completed',
        ]);
        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $user = auth()->user();
        $todo = Todo::where('user_id', $user->id )->findOrFail($todo->id);
        $todo->delete();
        // $data[0] = 1;
        // $data[1] =  count($user->todos);
        $data[2] = 'success removing from todo list';
        return response()->json($data);
    }
}
