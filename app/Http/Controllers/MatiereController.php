<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Note;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matieres = Matiere::all();
        return response()->json($matieres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $matieres = Matiere::create($request->all());
        return response()->json($matieres, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matieres = Matiere::findOrFail($id);
        return response()->json($matieres);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $matieres = Matiere::findOrFail($id);
        $matieres->update($request->all());
        return response()->json($matieres, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matieres = Matiere::findOrFail($id);
        $matieres->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idMatiere
     * @return \Illuminate\Http\Response
     */
    public function showNotesOfMatiere($idMatiere)
    {
        $notes = Note::where('matiere_id', $idMatiere)
            ->get();
        return response()->json($notes, 200);
    }
}
