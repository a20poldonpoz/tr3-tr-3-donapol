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
                'columna' => $seat['columna'], 
                'fila' => $seat['fila'],  
                'vip' => $seat['vip'],
            ]);
        }
        return response()->json(['message' => 'Seient afegit'], 201);
    }

    public function show($id)
    {
        return Seat::where('movie_id', $id)->get();
    }

    public function updateStatus($id)
    {
        $seat = Seat::find($id);

        if (!$seat) {
            return response()->json(['message' => 'El asiento no se encontró'], 404);
        }

        $seat->status = 'false';
        $seat->save();

        return response()->json(['message' => 'Estado del asiento actualizado correctamente'], 200);
    }

    public function generateSeats(Request $request)
    {
        $data = $request->all();

        $movie_id = $data['movie_id'];
        $fila_vip = $data['fila_vip'];

        $seats = [];

        for ($fila = 1; $fila <= 12; $fila++) {
            for ($columna = 1; $columna <= 10; $columna++) {
                $vip = ($fila == $fila_vip) ? 'true' : 'false';
                $seats[] = [
                    'movie_id' => $movie_id,
                    'status' => 'true',
                    'columna' => $columna,
                    'fila' => $fila,
                    'vip' => $vip
                ];
            }
        }

        Seat::insert($seats);

        return response()->json(['message' => 'Seients creats correctament'], 201);
    }

}