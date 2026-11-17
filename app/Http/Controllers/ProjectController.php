<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['category', 'technologies'])
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('judul', 'like', '%' . $search . '%')
                        ->orWhere('short_description', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->when($request->category, function ($q, $categorySlug) {
                $q->where(function ($sub) use ($categorySlug) {
                    $sub->whereHas('category', fn($w) => $w->where('slug', $categorySlug))
                        ->orWhere('kategori', 'like', '%' . str_replace('-', ' ', $categorySlug) . '%');
                });
            })
            ->when($request->technology, function ($q, $techSlug) {
                $q->whereHas('technologies', fn($w) => $w->where('slug', $techSlug));
            })
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            });

        switch ($request->query('sort')) {
            case 'terlama':
                $query->oldest();
                break;
            case 'az':
                $query->orderBy('judul', 'asc');
                break;
            case 'tanggal_terbaru':
                $query->orderByRaw('project_date IS NULL, project_date DESC');
                break;
            case 'tanggal_terlama':
                $query->orderByRaw('project_date IS NULL, project_date ASC');
                break;
            default:
                $query->latest();
                break;
        }

        $perPage = in_array((int) $request->per_page, [5, 9, 10, 25]) ? (int) $request->per_page : 10;

        $projects = $query->paginate($perPage)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.index', compact('projects', 'categories', 'technologies'));
    }

    public function trash()
    {
        $trashedProjects = Project::onlyTrashed()->latest()->get();
        return view('projects.trash', compact('trashedProjects'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();
        return view('projects.create', compact('categories', 'technologies'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul'             => 'required|string|min:5|max:255',
            'category_id'       => 'nullable|exists:categories,id',
            'kategori'          => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:255',
            'deskripsi'         => 'required|string|min:10',
            'project_date'      => 'nullable|date',
            'tautan'            => 'nullable|url',
            'status'            => 'nullable|in:draft,published',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
            'technologies'      => 'nullable|array',
            'technologies.*'    => 'exists:technologies,id',
        ], [
            'thumbnail.image'      => 'File thumbnail harus berupa gambar (bukan dokumen/PDF).',
            'thumbnail.mimes'      => 'Format thumbnail harus berupa: jpg, jpeg, png, atau webp.',
            'thumbnail.max'        => 'Ukuran file thumbnail maksimal 2 MB (2048 KB).',
            'thumbnail.dimensions' => 'Dimensi gambar terlalu kecil! Minimal berukuran 400 x 300 piksel.',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['judul']);

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $validatedData['status'] = $validatedData['status'] ?? 'published';

        $technologyIds = $validatedData['technologies'] ?? [];
        unset($validatedData['technologies']);

        $project = Project::create($validatedData);

        if (!empty($technologyIds)) {
            $project->technologies()->sync($technologyIds);
        }

        return redirect()->route('projects.index')
            ->with('success', 'Project baru berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $project = Project::with(['category', 'technologies', 'images'])
            ->where('id', $id)
            ->orWhere('slug', $id)
            ->firstOrFail();

        return view('projects.show', compact('project'));
    }

    public function edit(string $id)
    {
        $project = Project::with('technologies')->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();
        return view('projects.edit', compact('project', 'categories', 'technologies'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'judul'             => 'required|string|min:5|max:255',
            'category_id'       => 'nullable|exists:categories,id',
            'kategori'          => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:255',
            'deskripsi'         => 'required|string|min:10',
            'project_date'      => 'nullable|date',
            'tautan'            => 'nullable|url',
            'status'            => 'nullable|in:draft,published',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
            'technologies'      => 'nullable|array',
            'technologies.*'    => 'exists:technologies,id',
        ], [
            'thumbnail.image'      => 'File thumbnail harus berupa gambar (bukan dokumen/PDF).',
            'thumbnail.mimes'      => 'Format thumbnail harus berupa: jpg, jpeg, png, atau webp.',
            'thumbnail.max'        => 'Ukuran file thumbnail maksimal 2 MB (2048 KB).',
            'thumbnail.dimensions' => 'Dimensi gambar terlalu kecil! Minimal berukuran 400 x 300 piksel.',
        ]);

        $project = Project::findOrFail($id);
        $validatedData['slug'] = Str::slug($validatedData['judul']);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $technologyIds = $validatedData['technologies'] ?? null;
        unset($validatedData['technologies']);

        $project->update($validatedData);

        if (is_array($technologyIds)) {
            $project->technologies()->sync($technologyIds);
        }

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

        if ($project->thumbnail && Storage::disk('public')->exists($project->thumbnail)) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        if ($project->images) {
            foreach ($project->images as $image) {
                if ($image->image && Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }
        }

        if (method_exists($project, 'technologies')) {
            $project->technologies()->detach();
        }

        $project->forceDelete();

        return redirect()->route('projects.trash')
            ->with('success', 'Project beserta seluruh file gambarnya berhasil dihapus secara permanen!');
    }
}