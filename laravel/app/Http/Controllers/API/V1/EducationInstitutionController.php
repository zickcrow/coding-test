<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\EducationInstitution;
use Illuminate\Http\Request;

class EducationInstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(EducationInstitution::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationInstitution  $educationInstitution
     * @return \Illuminate\Http\Response
     */
    public function show(EducationInstitution $educationInstitution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationInstitution  $educationInstitution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationInstitution $educationInstitution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationInstitution  $educationInstitution
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationInstitution $educationInstitution)
    {
        //
    }
}
