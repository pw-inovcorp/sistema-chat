<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userRooms = auth()->user()->rooms()->get();

        $availableRooms = Room::whereDoesntHave('users', fn($q) => $q
            ->where('user_id', auth()->id())
        )->get();

        return view('rooms/index', ['userRooms' => $userRooms, 'availableRooms' => $availableRooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Apenas admins podem criar salas');
        }

        return view('rooms/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Apenas adminins podem criar salas');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:25|unique:rooms,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('room-avatars', 'public');
        }

        $room = Room::create($validated);


        return redirect()->route('rooms.index')
            ->with('success', 'Sala criada com sucesso');
    }

    public function join(Room $room)
    {

        if ($room->users()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('rooms.index')
                ->with('error', 'Já pertence a esta sala.');
        }

        // Adicionar o utilizador à sala
        $room->users()->attach(auth()->id());

        return redirect()->route('rooms.index')
            ->with('success', "Entrou na sala '{$room->name}'");
    }

    public function leave(Room $room)
    {
        if (!$room->users()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('rooms.index')
                ->with('error', 'Não pertence a esta sala.');
        }

        // Remover o utilizador da sala
        $room->users()->detach(auth()->id());

        return redirect()->route('rooms.index')
            ->with('success', "Saiu da sala '{$room->name}'");
    }


    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
