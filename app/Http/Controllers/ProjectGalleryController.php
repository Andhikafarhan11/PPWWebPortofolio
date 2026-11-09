<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=400,min_height=300',
        ], [
            'images.max'          => 'Maksimal hanya dapat mengunggah 10 gambar sekaligus.',
            'images.*.image'      => 'File yang diunggah harus berupa gambar (bukan dokumen/PDF).',
            'images.*.mimes'      => 'Format gambar galeri harus berupa: jpg, jpeg, png, atau webp.',
            'images.*.max'        => 'Ukuran setiap gambar galeri maksimal 4 MB (4096 KB).',
            'images.*.dimensions' => 'Dimensi gambar galeri terlalu kecil! Minimal berukuran 400 x 300 piksel.',
        ]);

        foreach ($request->file('images') as $file) {
            $project->images()->create([
                'image' => $file->store('projects/gallery', 'public'),
            ]);
        }

        return back()->with('success', 'Gambar gallery berhasil diunggah.');
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        // Pastikan gambar yang akan dihapus memang milik project tersebut
        abort_if($image->project_id !== $project->id, 404);

        // Hapus file fisik dari storage/app/public
        Storage::disk('public')->delete($image->image);

        // Hapus baris data dari database
        $image->delete();

        return back()->with('success', 'Gambar gallery dihapus.');
    }
}