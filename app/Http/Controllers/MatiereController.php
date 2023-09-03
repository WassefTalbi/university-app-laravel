<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Matiere;
use App\Models\Module;
use App\Models\Note;
use Carbon\Carbon;
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
        $matieres = Matiere::with('evaluations')->get();
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
            'evaluations' => 'required|array',


        ]);
        $module = Module::find($idModule);

        if (!$module) {
         
            return response()->json(['error' => 'module not found'], 404);
        }
        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName(); 
        $filePath = $file->storeAs('public/uploads', $originalFileName); 
        $matiereData = $request->except('file');
        $matiereData['photo_url'] = $originalFileName;
        $matiereData['module_id'] = $idModule;
        $matiere = Matiere::create($matiereData);
        foreach ($request->input('evaluations') as $evaluationData) {
            $matiere->evaluations()->create($evaluationData);
        }
     
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
        $matiere = Matiere::findOrFail($id);
        return response()->json($matiere);
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
        $matiere = Matiere::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'credit' => 'required|int|max:255',
            'coefficient' => 'required|int|max:255',
            'charge_total' => 'required|int|max:255',
            'evaluations' => 'array', 


        ]);
        if ($request->hasFile("file")) {
            Storage::delete('uploads/' . $matiere->photo_url);
            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('public/uploads', $originalFileName);
            $matiere = $request->except('file');
            $matiere['photo_url'] = $originalFileName;
        }
        $matiere->update($request->except(['file']));
        if ($request->has('evaluations')) {
            foreach ($request->input('evaluations') as $index => $evaluationData) {
                if (isset($evaluationData['id'])) {
                    // Update existing evaluation
                    $evaluation = Evaluation::findOrFail($evaluationData['id']);
                    $evaluation->update($evaluationData);
                } else {
                    // Create new evaluation
                    $matiere->evaluations()->create($evaluationData);
                }
            }
        }
        return response()->json($matiere, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matiere = Matiere::findOrFail($id);      
        $matiere->classrooms()->detach();
        $matiere->evaluations()->delete();
        $matiere->delete();
        return response()->json(null, 204);
    }
  
/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMatiereEvalutions($id)
    {    
       $matiere = Matiere::findOrFail($id);
        if (!$matiere) {
            return response()->json(['error' => 'Matiere not found'], 404);
        }
        $matiereEvaluations = $matiere->load('evaluations');
       
        return response()->json($matiereEvaluations);
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

  

    public function updateOrCreate(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'evaluation_name' => 'required|string',
        'matiere_id' => 'required|exists:matieres,id', // Use the matiere ID instead of name
        'value' => 'required|numeric|min:0|max:20', // Adjust validation rules as needed
    ]);

    // Find an existing note or create a new one
    $note = Note::firstOrNew([
        'etudiant_id' => $id,
        'matiere_id' => $request->matiere_id,
        'name' => $request->evaluation_name,
    ]);

    // Update the score with the new value
    $note->score = $request->value;

    // Save the note (this will either update an existing note or create a new one)
    $note->save();

    return response()->json(['message' => 'Note updated or created successfully'], 200);
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
