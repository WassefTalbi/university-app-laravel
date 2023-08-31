<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Etudiant;
use App\Models\Matiere;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etudiants = Etudiant::query()->orderBy('id')->paginate(2);

        //$etudiants = Etudiant::all();
        return response()->json($etudiants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birthday' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->format('Y-m-d'),
            ],
            'cin' => [
                'required',
                'string',
                'unique:etudiants',
                'regex:/^\d{8}$/',
            ],
        ]);
        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName(); 
        $filePath = $file->storeAs('public/uploads', $originalFileName); 
        $etudiantData = $request->except('file'); 
        $etudiantData['photo_url'] = $originalFileName;

        $etudiant = Etudiant::create($etudiantData);
        return response()->json($etudiant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return response()->json($etudiant);
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
        $etudiant = Etudiant::findOrFail($id);
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'birthday' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->format('Y-m-d'),
            ],
            'cin' => [
                'required',
                'string',
                'regex:/^\d{8}$/',
            ],
        ]);
        if($request->hasFile("file")){
          
            Storage::delete('uploads/' . $etudiant->photo_url);
   
                $file = $request->file('file');
                $originalFileName = $file->getClientOriginalName(); 
                $filePath = $file->storeAs('public/uploads', $originalFileName); 
                $etudiant = $request->except('file'); 
                $etudiant['photo_url'] = $originalFileName;
            }

        

        // Update other fields
        $etudiant->update($request->except(['file']));

        return response()->json($etudiant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();
        return response()->json(null, 204);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEtudiantsByClass($idClass)
    {
        $refClass=Classroom::find($idClass)->value("ref");
         $etudiants = Etudiant::where('current_classroom', $refClass)
         ->get();
      
        return response()->json($etudiants);
    }
    

}
