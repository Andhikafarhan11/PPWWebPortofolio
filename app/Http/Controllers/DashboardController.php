<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private array $cacheKeys = [
        'portfolio.featured'    => 'Featured Projects (Home)',
        'portfolio.skills'      => 'Skills (Home)',
        'portfolio.categories'  => 'Categories (Projects)',
        'portfolio.experiences' => 'Experiences (About)',
        'portfolio.educations'  => 'Educations (Education)',
    ];

    public function index()
    {
        $cacheStatus = [];
        foreach ($this->cacheKeys as $key => $label) {
            $cacheStatus[$key] = [
                'label'  => $label,
                'exists' => Cache::has($key),
            ];
        }

        return view('dashboard', [
            'totalProjects'     => Project::count(),
            'totalCategories'   => class_exists(\App\Models\Category::class) ? \App\Models\Category::count() : 0,
            'totalTechnologies' => class_exists(\App\Models\Technology::class) ? \App\Models\Technology::count() : 0,
            'totalSkills'       => class_exists(\App\Models\Skill::class) ? \App\Models\Skill::count() : 0,
            'totalMessages'     => Contact::count(),
            'unreadMessages'    => Contact::where('is_read', false)->count(),
            'latestProjects'    => Project::latest()->take(5)->get(),
            'cacheStatus'       => $cacheStatus,
            'pendingJobs'       => DB::table('jobs')->count(),
            'failedJobs'        => DB::table('failed_jobs')->count(),
        ]);
    }

    public function clearCache(Request $request)
    {
        $key = $request->input('key');

        if ($key && array_key_exists($key, $this->cacheKeys)) {
            Cache::forget($key);
            return back()->with('success', "Cache '{$key}' berhasil dibersihkan.");
        }

        foreach (array_keys($this->cacheKeys) as $cacheKey) {
            Cache::forget($cacheKey);
        }

        return back()->with('success', 'Seluruh cache portfolio berhasil dibersihkan.');
    }
}