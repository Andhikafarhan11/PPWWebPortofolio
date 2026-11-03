<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::published()->latest();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $perPage = in_array((int) $request->per_page, [5, 10, 25]) ? (int) $request->per_page : 10;

        $projects = $query->paginate($perPage)->withQueryString();

        return view('projects.index', compact('projects'));
    }

    public function trash()
    {
        $trashedProjects = Project::onlyTrashed()->latest()->get();
        return view('projects.trash', compact('trashedProjects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul'     => 'required|string|min:5|max:255',
            'kategori'  => 'nullable|string|max:100',
            'deskripsi' => 'required|string|min:10',
            'tautan'    => 'nullable|url',
            'status'    => 'nullable|in:draft,published',
        ]);

        $validatedData['status'] = $validatedData['status'] ?? 'published';

        Project::create($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project baru berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'judul'     => 'required|string|min:5|max:255',
            'kategori'  => 'nullable|string|max:100',
            'deskripsi' => 'required|string|min:10',
            'tautan'    => 'nullable|url',
            'status'    => 'nullable|in:draft,published',
        ]);

        $project = Project::findOrFail($id);
        $project->update($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dipindahkan ke sampah!');
    }

    public function restore(string $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('projects.trash')
            ->with('success', 'Project berhasil dipulihkan!');
    }

    public function forceDelete(string $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()->route('projects.trash')
            ->with('success', 'Project berhasil dihapus secara permanen!');
    }
}