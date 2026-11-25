<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Cache;

class PortfolioController extends Controller
{
    public function home()
    {
        $featured = Cache::remember('portfolio.featured', 1800, fn () =>
            Project::with('category')
                ->where('status', 'published')
                ->latest()
                ->take(6)
                ->get()
        );

        $skills = Cache::remember('portfolio.skills', 3600, fn () =>
            Skill::orderBy('name')->get()
        );

        return view('home', compact('featured', 'skills'));
    }

    public function about()
    {
        $experiences = Cache::remember('portfolio.experiences', 3600, fn () =>
            Experience::latest()->get()
        );

        return view('about', compact('experiences'));
    }

    public function education()
    {
        $educations = Cache::remember('portfolio.educations', 3600, fn () =>
            Education::latest()->get()
        );

        return view('education', compact('educations'));
    }
}