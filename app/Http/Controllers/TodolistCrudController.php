<?php

namespace App\Http\Controllers;

use App\Models\todolist_crud;
use Illuminate\Http\Request;

class TodolistCrudController extends Controller
{
    public function index()
    {
        // READ (GET)
        try{
            $todolist = todolist_crud::all();
            return response()->json($todolist, 200);

        }catch(\Exception $error)
        {
            return response()->json($error->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        //CREATE(POST)
        try{
            todolist_crud::create($request->all());
            return response()->json("Todo list created sucessfully", 201);
        }catch(\Exception $error)
        {
            return response()->json($error->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try{
            $todolist = todolist_crud::find($id);
            $todolist->update($request->all());
            return response()->json("Todo list updated sucessfully", 201);
            
        }catch(\Exception $error)
        {
            return response()->json($error->getMessage(), 500);
        }
    }

    public function destroy(int $id)
    {
        try{
            $todolist = todolist_crud::find($id);
            $todolist->delete();
            return response()->json("Todo list deleted sucessfully", 201);
        }catch(\Exception $error)
        {
            return response()->json($error->getMessage(), 500);
        }
    }
}
