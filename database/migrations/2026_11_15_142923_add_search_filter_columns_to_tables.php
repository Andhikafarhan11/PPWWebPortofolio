<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom-kolom baru Pertemuan 11 pada tabel projects
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('judul');
            }
            if (!Schema::hasColumn('projects', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('slug')->constrained('categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('projects', 'short_description')) {
                $table->string('short_description')->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('projects', 'status')) {
                $table->string('status')->default('draft')->after('deskripsi');
            }
            if (!Schema::hasColumn('projects', 'project_date')) {
                $table->date('project_date')->nullable();
            }
            if (!Schema::hasColumn('projects', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            if (!Schema::hasColumn('projects', 'project_url')) {
                $table->string('project_url')->nullable();
            }
            if (!Schema::hasColumn('projects', 'repository_url')) {
                $table->string('repository_url')->nullable();
            }
        });

        // 2. Pastikan kolom slug ada di tabel categories
        if (Schema::hasTable('categories') && !Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        // 3. Pastikan kolom slug ada di tabel technologies
        if (Schema::hasTable('technologies') && !Schema::hasColumn('technologies', 'slug')) {
            Schema::table('technologies', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('name');
            });
        }

        // 4. Pastikan tabel pivot project_technology tersedia dengan composite primary key
        if (!Schema::hasTable('project_technology')) {
            Schema::create('project_technology', function (Blueprint $table) {
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
                $table->foreignId('technology_id')->constrained()->cascadeOnDelete();
                $table->primary(['project_id', 'technology_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'slug')) {
                $table->dropUnique(['slug']);
            }
            if (Schema::hasColumn('projects', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            $table->dropColumn([
                'slug',
                'short_description',
                'project_date',
                'is_featured',
                'project_url',
                'repository_url',
            ]);
        });
    }
};