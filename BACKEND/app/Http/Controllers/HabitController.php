<?php

namespace App\Http\Controllers;

use App\Http\Requests\Habits\HabitCreateRequest;
use App\Services\Habits\HabitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $userId = Auth::id();
        $habits = $this->habitService->getAll($userId);
        return response()->json($habits);
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

        $data['user_id'] = Auth::id();

        $habit = $this->habitService->create($data);

        return response()->json($habit, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $habit = $this->habitService->getById($id, Auth::id());

        if (!$habit) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($habit);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $habit = $this->habitService->getById($id, 2);
        return view('habits.edit', compact('habit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HabitCreateRequest $request, int $id)
    {
        $data = $request->validated();

        $habit = $this->habitService->update($id, $data);

        if (!$habit) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($habit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $success = $this->habitService->delete($id, Auth::id());
        return response()->json(['success' => $success]);
    }

    public function updateLog(Request $request, int $id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'status' => 'required|integer|in:0,1',
        ]);

        $data['is_done'] = $data['status'];
        unset($data['status']);

        $log = $this->habitService->updateLog($id, $data);

        return response()->json([
            'message' => 'Статус обновлён',
            'log' => $log,
        ]);
    }

}
