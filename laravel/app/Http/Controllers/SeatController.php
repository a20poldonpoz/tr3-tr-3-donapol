<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    //

    public function index()
    {
        return Seat::all();
    }

    public function insert(Request $request)
    {
        $seats = $request->json()->all();

       

        foreach ($seats as $seat) {
            Seat::create([
                'movie_id' => $seat['movie_id'],
                'status' => $seat['status'],
            ]);
        }
        return response()->json(['message' => 'seats inserted'], 201);
    }


    public function show($id)
    {
        return Seat::where('movie_id', $id)->get();
    }
}