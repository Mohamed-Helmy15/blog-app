<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;

class EmployerController extends Controller
{

    public function __construct(){
        //$this->authorizeResource(Employer::class, "employer");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['data'=> Employer::all()->load("user")]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required|numeric',
        ]);
        Employer::create([
            'user_id'=> $request->user_id,
        ]);
        return response()->json(['message'=>"employer created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
        return response()->json(["data"=> Employer::findOrFail($employer->id)->load('user')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employer $employer)
    {
        $userEmployer = User::findOrFail($employer->user_id);
        $userEmployer->update($request->all());
        return response()->json(["data"=> $userEmployer]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        $user = User::findOrFail($employer->user_id);
        $user->delete();
        $employer->delete();
        return response()->json();
    }
    public function getAllUsers()
    {
        $allUsers = User::all();
        return response()->json(['data'=> $allUsers]);
    }
}
