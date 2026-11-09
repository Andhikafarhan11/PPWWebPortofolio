<?php

namespace App\Http\Controllers;

use App\Models\Project;
// Jika model Category, Skill, Technology sudah ada, uncomment baris di bawah:
// use App\Models\{Category, Skill, Technology};

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProjects'     => Project::count(),
            'totalCategories'   => class_exists(\App\Models\Category::class) ? \App\Models\Category::count() : 0,
            'totalTechnologies' => class_exists(\App\Models\Technology::class) ? \App\Models\Technology::count() : 0,
            'totalSkills'       => class_exists(\App\Models\Skill::class) ? \App\Models\Skill::count() : 0,
            'latestProjects'    => Project::latest()->take(5)->get(),
        ]);
    }
}