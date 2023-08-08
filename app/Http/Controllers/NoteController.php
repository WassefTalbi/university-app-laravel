<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notes = Note::all();
        return response()->json($notes);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idNote
     * @return \Illuminate\Http\Response
     */
    public function modifyNote($idNote, Request $request)
    {
        $note = Note::find($idNote);
        if (!$note) {
            // Handle case when etudiant or matiere is not found
            return response()->json(['error' => 'note not found'], 404);
        }
        $note->score = $request["score"];
        $note->update();

        return response()->json($note, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idNote
     * @return \Illuminate\Http\Response
     */
    public function destroy($idNote)
    {
        $note = Note::find($idNote);
        $note->delete();
        return response()->json(null, 204);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idMatiere
     * @param  int  $idEtudiant
     * @return \Illuminate\Http\Response
     */
    public function noted($idMatiere, $idEtudiant, Request $request)
    {

        $matiere = Matiere::find($idMatiere);
        $etudiant = Etudiant::find($idEtudiant);
        if (!$etudiant || !$matiere) {
            // Handle case when etudiant or matiere is not found
            return response()->json(['error' => 'etudiant or matiere not found'], 404);
        }
        // Check if the etudiant is already noted in the given matiere
        $existingNote = Note::where('etudiant_id', $etudiant->id)
            ->where('matiere_id', $matiere->id)
            ->first();

        if ($existingNote) {
            return response()->json(['error' => 'etudiant is already noted in this matiere'], 400);
        }
        $note = new Note();
        $note->matiere_id = $matiere->id;
        $note->etudiant_id = $etudiant->id;
        $note->score = $request['score'];

        $note->save();
        return response()->json($note, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idEtudiant
     * @return \Illuminate\Http\Response
     */
    public function generateEtudiantNotesFile($idEtudiant)
    {
        //$etudiant = Etudiant::findOrFail($idEtudiant);
        $etudiant = Etudiant::with('notes.matiere')->find($idEtudiant);

        if (!$etudiant) {
            // Handle case when etudiant is not found
            return response()->json(['error' => 'etudiant not found'], 404);
        }
        //  $notes = $etudiant->notes;
        $notesWithMatieres = $etudiant->notes->map(function ($note) {
            return [
                'matiere' => $note->matiere->name,
                'note' => $note->score

            ];
        });
        return response()->json($notesWithMatieres, 200);
    }
}
