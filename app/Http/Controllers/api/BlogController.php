<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Employer;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function __construct() {
        //$this->authorizeResource(Blog::class, "blog");
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json([
            'data'=> Blog::orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     $employer = Employer::where('user_id', $request->user()->id)->first()->id;
        $request->validate([
            'category'=>'required',
            'title'=>'required',
            'is_paid'=>'boolean',
            'section_title' => 'required',
            'content' => 'string',
            'image.*'=> 'image|mimes:jpeg,png,jpg,svg'
        ]);
        $blog = Blog::create([
            'category'=>$request->category,
            'title'=>$request->title,
            'employer_id'=>$employer,
            'is_paid'=>$request->is_paid,
        ]);
        
        if($request->image){
            $imageName = time().'_'.$request->user()->id.$request->image->getClientOriginalName();
            $request->image->move(public_path('images'),$imageName);
        }
            
        $blog->section()->create([
            'section_title' => $request->section_title,
            'content' => $request->content? $request->content: null,
            'image' => $request->image ? $imageName : null,    
        ]);
        
        return response()->json(['message'=>"blog created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return response()->json(["data"=> $blog->load('section')]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'category'=>'string',
            'title'=>'string',
            'employer_id'=>'numeric',
            'is_paid'=>'boolean',
        ]);
        $blog->update($request->all());
        return response()->json(['message'=>"blog edited successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->section()->delete();
        $blog->delete();
        return response('', 204);
    }
}
