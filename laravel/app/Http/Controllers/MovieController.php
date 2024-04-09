<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
   

  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'titol' => 'required|string',
      'director' => 'required|string',
      'any' => 'required|integer',
      'descripcio' => 'required|string',
      'hora' => 'required|date_format:H:i:s',
  ]);

      $movie = Movie::create($validatedData);

      return response()->json($movie, 201);
  }

    public function index()
    {
        return Movie::all();
    }

    public function show($id)
    {
        return Movie::find($id);
    }

    public function update(Request $request, $id)
    {     
      $movie = Movie::findOrFail($id);
      $movie->update($request->all());
    
      return response()->json($movie, 200);
    }

    public function destroy($id){
      $movie = Movie::findOrFail($id);
      $movie->delete();
      return response()->json(['message' => 'Película eliminada correctamente'], 200);
  }
}
