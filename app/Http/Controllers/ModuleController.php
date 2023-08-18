<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\Request;


class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matieres = Module::all();
        return response()->json($matieres);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idSpecialite
     * @return \Illuminate\Http\Response
     */
    public function store($idSpecialite, Request $request)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'ref' => 'required|string|max:255',
            'nature' => 'required|string|max:255',
            'credit' => 'required|int|max:255',
            'coefficient' => 'required|int|max:255',
        ]);
        $specialite = Specialite::find($idSpecialite);

        if (!$specialite) {
            // Handle case when etudiant or matiere is not found
            return response()->json(['error' => 'specialite not found'], 404);
        }
        $moduleData = $request;
        $moduleData['specialite_id'] = $idSpecialite;
        $modules = Module::create($moduleData->all());
        return response()->json($modules, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modules = Module::findOrFail($id);
        return response()->json($modules);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'ref' => 'required|string|max:255',
            'nature' => 'required|string|max:255',
            'credit' => 'required|int|max:255',
            'coefficient' => 'required|int|max:255',
        ]);
        $modules = Module::findOrFail($id);
        $modules->update($request->all());
        return response()->json($modules, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modules = Module::findOrFail($id);
        $modules->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idMatiere
     * @return \Illuminate\Http\Response
     */
    public function showMatieresOfModule($idModule)
    {
        $matieres = Matiere::where('module_id', $idModule)
            ->get();
        return response()->json($matieres, 200);
    }
}
