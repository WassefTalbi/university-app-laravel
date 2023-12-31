<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Degre;
use App\Models\Matiere;
use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\Request;


class SpecialiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialites = Specialite::with("degres")->get();
        return response()->json($specialites);
    }
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSpecialitiesGroupByNiveau()
    {
        $specialites = Specialite::select('specialites.id','specialites.type', 'degres.niveau')
        ->leftJoin('degres', 'specialites.id', '=', 'degres.specialite_id')
        ->distinct()
        ->get();
        return response()->json($specialites);
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

            'type' => 'required|string|max:255',
            'niveau' => 'required|int|max:255',
            'semestre' => 'required|int|max:255',
        ]);
        $specialite = Specialite::create($request->all());
        return response()->json($specialite, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $specialite = Specialite::findOrFail($id);
        return response()->json($specialite);
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
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'niveau' => 'required|int|max:255',
            'semestre' => 'required|int|max:255',
        ]);
        $specialite = Specialite::findOrFail($id);
        $specialite->update($request->all());
        return response()->json($specialite, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialite = Specialite::findOrFail($id);
        $specialite->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idSpecialite
     * @return \Illuminate\Http\Response
     */
    public function showModulesOfSpecialite($idSpecialite)
    {
        $modules = Module::where('specialite_id', $idSpecialite)
            ->get();
        return response()->json($modules, 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $idDegre
     * @return \Illuminate\Http\Response
     */
    public function generatePlanDEtude($idDegre)

    {
        $degre = Degre::find($idDegre);
        if (!$degre) {
            return response()->json(['error' => 'Degree not found'], 404);
        }
        $plan = $degre->load('modules.matieres.evaluations');

        return response()->json($plan, 200);
    }
}
