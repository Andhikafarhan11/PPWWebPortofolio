<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // Menampilkan hanya project yang berstatus published
    public function index()
    {
        $projects = Project::published()->latest()->get();
        return view('projects.index', compact('projects'));
    }

    // Menampilkan halaman sampah (project yang di-soft delete)
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

        // Default status jika tidak diisi
        $validatedData['status'] = $validatedData['status'] ?? 'published';

        Project::create($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project baru berhasil ditambahkan!');
    }

    public function show($id)
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

    // Soft Delete Project
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dipindahkan ke sampah!');
    }

    // Restore Project dari Sampah
    public function restore($id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('projects.trash')
            ->with('success', 'Project berhasil dipulihkan!');
    }

    // Permanent Delete Project
    public function forceDelete($id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()->route('projects.trash')
            ->with('success', 'Project berhasil dihapus secara permanen!');
    }
}