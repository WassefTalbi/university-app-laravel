<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Department;
use App\Models\Matiere;
use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\Request;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with("classrooms")->get();
        return response()->json($departments);
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
            'name' => 'required|string|max:255',
           
            
        ]);
        $department = Department::create($request->all());  
        return response()->json($department, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idDepartment)
    { 
         $request->validate([           
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
     ]);
        $department = Department::findOrFail($idDepartment);
        $department->update($request->all());
        return response()->json($department, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $idDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy($idDepartment)
    {
        $department= Department::findOrFail($idDepartment);
        $department->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $idDepartment
     * @return \Illuminate\Http\Response
     */
    public function showClassroomsOfDepartment($idDepartment)
    {
        $classrooms = Classroom::where('department_id', $idDepartment)
            ->get();
        return response()->json($classrooms, 200);
    }




}

