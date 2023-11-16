<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return response()->json($user
            ->todos()
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withPath('/api/todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'is_completed' => 'required|boolean',
        ]);

        $todo = new Todo;
        $todo->description = $validated['description'];
        $todo->is_completed = $validated['is_completed'];

        $user = $request->user();
        $user->todos()->save($todo);

        return response()->json($user
            ->todos()
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withPath('/api/todos'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        return response()->json($todo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Todo $todo
     * @return void
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'is_completed' => 'required|boolean',
        ]);

        $todo->is_completed = $validated['is_completed'];
        $todo->save();

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return void
     */
    public function destroy(Request $request, Todo $todo)
    {
        $todo->delete();

        return response()->json($request->user()
            ->todos()
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withPath('/api/todos'));
    }
}
