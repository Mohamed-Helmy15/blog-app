<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Employer;
use App\Models\Section;
use Illuminate\Http\Request;
class SectionController extends Controller
{

    public function __construct(){
        $this->authorizeResource(Section::class, 'section');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        return response()->json([
        'data' => $blog->section->load('blog')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog)
    {
        $this->authorize('create-section', [ $blog ]);
        $request->validate([
            'section_title' => 'required',
            'content' => 'string',
            'image.*'=> 'image|mimes:jpeg,png,jpg,svg'
        ]);
        if($request->image){
            $imageName = time().'_'.$request->user()->id.$request->image->getClientOriginalName();
            $request->image->move(public_path('images'),$imageName);
        }

        $blog->section()->create([
            'section_title' => $request->section_title,
            'content' => $request->content,
            'image' => $request->image ? $imageName : null,
        ]);

        return response()->json([
            'message' => 'Section created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog , Section $section)
    {
        return response()->json([
            'data'=> $section->load('blog')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog )
    {
       return response()->json([
        'data'=> $request->all(),
       ]);
    }
    public function updateSec(Request $request, Blog $blog , Section $section)
    {
        $this->authorize('update-section', [ $blog ]);
         $request->validate([
            'section_title' => 'string',
            'content' => 'string',
            'image.*'=> 'image|mimes:jpeg,png,jpg,svg'
        ]);
        if($request->image){
            $imageName = time().'_'.$request->user()->id.$request->image->getClientOriginalName();
            $request->image->move(public_path('images'),$imageName);
            $section->update([
                'image' => $imageName
            ]);
        }
        if($request->content){
            $section->update([
            'content' => $request->content
            ]);
        }
        if($request->section_title){
            $section->update([
                'section_title' => $request->section_title
            ]);
        }
        return response()->json([
            'message' => "section updated successfully",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, Section $section)
    {
        $section->delete();
        return response('',204);
    }
}
