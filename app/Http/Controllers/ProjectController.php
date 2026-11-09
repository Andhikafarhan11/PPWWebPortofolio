<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

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
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ], [
            'thumbnail.image'      => 'File thumbnail harus berupa gambar (bukan dokumen/PDF).',
            'thumbnail.mimes'      => 'Format thumbnail harus berupa: jpg, jpeg, png, atau webp.',
            'thumbnail.max'        => 'Ukuran file thumbnail maksimal 2 MB (2048 KB).',
            'thumbnail.dimensions' => 'Dimensi gambar terlalu kecil! Minimal berukuran 400 x 300 piksel.',
        ]);

        // Simpan file thumbnail ke folder storage/app/public/projects/thumbnails jika diunggah
        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $validatedData['status'] = $validatedData['status'] ?? 'published';

        Project::create($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project baru berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $project = Project::with('images')->findOrFail($id);
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
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ], [
            'thumbnail.image'      => 'File thumbnail harus berupa gambar (bukan dokumen/PDF).',
            'thumbnail.mimes'      => 'Format thumbnail harus berupa: jpg, jpeg, png, atau webp.',
            'thumbnail.max'        => 'Ukuran file thumbnail maksimal 2 MB (2048 KB).',
            'thumbnail.dimensions' => 'Dimensi gambar terlalu kecil! Minimal berukuran 400 x 300 piksel.',
        ]);

        $project = Project::findOrFail($id);

        // Jika ada thumbnail baru yang diunggah
        if ($request->hasFile('thumbnail')) {
            // Hapus file thumbnail lama dari disk public jika ada
            if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            // Simpan thumbnail baru
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

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
        $project = Project::withTrashed()->with('images')->findOrFail($id);

        // 1. Hapus file fisik thumbnail dari disk public
        if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        // 2. Hapus seluruh file fisik gambar gallery milik project ini
        if ($project->images) {
            foreach ($project->images as $image) {
                if ($image->image && Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }
        }

        // 3. Lepaskan relasi pivot technologies jika relasi didefinisikan
        if (method_exists($project, 'technologies')) {
            $project->technologies()->detach();
        }

        // 4. Hapus data secara permanen dari database
        $project->forceDelete();

        return redirect()->route('projects.trash')
            ->with('success', 'Project beserta seluruh file gambarnya berhasil dihapus secara permanen!');
    }
}