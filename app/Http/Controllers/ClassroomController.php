<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Department;
use App\Models\Matiere;
use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\Request;


class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::all();
        return response()->json($classrooms);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idDepartment
     * @return \Illuminate\Http\Response
     */
    public function store($idDepartment, Request $request)
    {

        $request->validate([

            'ref' => 'required|string|max:255',
            'anneScolaire' => 'required|string|max:255',
          
        ]);
        $department = Department::find($idDepartment);

        if (!$department) {
            // Handle case when etudiant or matiere is not found
            return response()->json(['error' => 'department not found'], 404);
        }
        $classroomData = $request;
        $classroomData['department_id'] = $idDepartment;
        $classroom = Classroom::create($classroomData->all());
        return response()->json($request, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
        return response()->json($classroom);
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
            'ref' => 'required|string|max:255',
            'anneScolaire' => 'required|string|max:255',
        ]);
        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());
        return response()->json($classroom, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMatieresOfClassroom($id)
    {
        $classroom = Classroom::with('matieres')->findOrFail($id);

        return response()->json($classroom);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function affectMatiereToClass(Request $request)
    {
        //  Validate the request data as needed
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'matiere_id' => 'required|array',
            'matiere_id.*' => 'exists:matieres,id',
        ]);

        $classroom = Classroom::findOrFail($request->input('classroom_id'));
        $matiereIds = $request->input('matiere_id');

        // Sync the matieres with the classroom
        $classroom->matieres()->sync($matiereIds);

        return response()->json(['message' => 'Subjects assigned to classroom successfully']);
}
}
