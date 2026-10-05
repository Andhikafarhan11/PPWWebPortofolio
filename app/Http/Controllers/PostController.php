<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Menampilkan daftar post berstatus published
    public function index()
    {
        $posts = Post::published()->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Menampilkan daftar post yang ada di sampah (Soft Delete)
    public function trash()
    {
        $trashedPosts = Post::onlyTrashed()->latest()->get();
        return view('posts.trash', compact('trashedPosts'));
    }

    // Menghapus sementara (Soft Delete)
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post berhasil dipindahkan ke sampah.');
    }

    // Memulihkan data dari sampah (Restore)
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trash')->with('success', 'Post berhasil dipulihkan.');
    }

    // Menghapus data secara permanen
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('posts.trash')->with('success', 'Post berhasil dihapus secara permanen.');
    }
}