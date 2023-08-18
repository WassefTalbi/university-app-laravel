<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Module;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * @param  int  $idModule
     * @return \Illuminate\Http\Response
     */
    public function store($idModule, Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpeg,png,pdf|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255', 
            'credit' => 'required|int|max:255',
            'coefficient' => 'required|int|max:255', 
            'charge_total' => 'required|int|max:255',
           
        ]);
        $module = Module::find($idModule);

        if (!$module) {
            // Handle case when etudiant or matiere is not found
            return response()->json(['error' => 'module not found'], 404);
        }
        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName(); // Get the original file name

        $filePath = $file->storeAs('public/uploads', $originalFileName); // Store the file in storage/app/uploads with the original name

        $matiereData = $request->except('file'); 
        $matiereData['photo_url'] = $originalFileName; 
        $matiereData['module_id'] = $idModule; 
        $matiere = Matiere::create($matiereData);

        //$matieres = Matiere::create($request->all());
        return response()->json($matiere, 201);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $idMatiere
     * @return \Illuminate\Http\Response
     */
    public function showNotesOfMatiereOfClassroom($idMatiere)
    {
        // $notes = Note::where('matiere_id', $idMatiere)
        //     ->get();
        $notes = Matiere::with("notes.etudiant")->find($idMatiere);
        return response()->json($notes, 200);
    }

    public function getImage($filename)
    {
        $imagePath = "public/uploads/{$filename}";

        if (!Storage::exists($imagePath)) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        $image = Storage::get($imagePath);
        $mimeType = Storage::mimeType($imagePath);

        return response($image)->header('Content-Type', $mimeType);
    }
}
