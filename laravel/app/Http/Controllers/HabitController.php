<?php

namespace App\Http\Controllers;

use App\Http\Requests\Habits\HabitCreateRequest;
use App\Models\Habits\Habit;
use App\Services\Habits\HabitService;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    public function __construct(protected HabitService $habitService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habits = $this->habitService->getAll(1);
        return view('habits.index', compact('habits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('habits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HabitCreateRequest $request)
    {
        $data = $request->validated();
        $habit = $this->habitService->create($data);
        return redirect()->route('habits.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $habit = $this->habitService->getById($id, 1);
        return view('habits.show', compact('habit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $habit = $this->habitService->getById($id, 1);
        return view('habits.edit', compact('habit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HabitCreateRequest $request, int $id)
    {
        $data = $request->validated();
        $this->habitService->update($id, $data);
        return redirect()->route('habits.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->habitService->delete($id, auth()->id());
        return redirect()->route('habits.index');
    }
}
