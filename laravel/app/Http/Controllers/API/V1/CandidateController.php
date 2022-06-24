<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Candidate\StoreRequest;
use App\Http\Requests\API\V1\Candidate\UpdateRequest;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use App\Models\Skill;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = CandidateResource::collection(Candidate::paginate(10))->response()->getData(true);
        return response()->json($candidates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\API\V1\Candidate\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $candidate = Candidate::create($request->validated());

        // Update skills
        if ($request->has('skills')) {
            $skills = collect($request->skills)->map(function ($skill) {
                return Skill::where('name', $skill)->first()->id;
            });
            $candidate->skills()->sync($skills);
        }

        // Store resume
        if ($request->hasFile('resume')) {
            $candidate->resume = $request->file('resume')->store('resumes');
        }
        $candidate->save();

        return response()->json($candidate, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::findOrFail($id);

        return response()->json(new CandidateResource($candidate));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\V1\Candidate\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->update($request->validated());

        // Update skills
        if ($request->has('skills')) {
            $skills = collect($request->skills)->map(function ($skill) {
                return Skill::where('name', $skill)->first()->id;
            });
            $candidate->skills()->sync($skills);
        }

        // Store resume
        if ($request->hasFile('resume')) {
            $candidate->resume = $request->file('resume')->store('resumes');
            $candidate->save();
        }

        return response()->json($candidate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->delete();

        return response()->json("Candidate {$id} successfully deleted", 204);
    }
}
