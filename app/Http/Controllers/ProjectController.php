<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function show($id)
    {
         $project = Project::find($id);
       
        return Inertia::render('Project/ProjectShow', [
            'project' => $project,
        ]);

    }
}