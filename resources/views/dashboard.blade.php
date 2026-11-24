<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('post.contacts.index') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Lihat Pesan Masuk ({{ $unreadMessages }} Belum Dibaca)
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Kartu Ringkasan Statistik (6 Stat Cards dengan Grid Rapi) --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <x-stat-card label="Projects" :value="$totalProjects" color="text-blue-600" />
                <x-stat-card label="Categories" :value="$totalCategories" color="text-green-600" />
                <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-purple-600" />
                <x-stat-card label="Skills" :value="$totalSkills" color="text-orange-600" />
                <x-stat-card label="Messages" :value="$totalMessages" color="text-indigo-600" />
                <x-stat-card label="Unread Messages" :value="$unreadMessages" color="text-red-600" />
            </div>

            {{-- Daftar 5 Project Terbaru --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">Project Terbaru</h3>

                    @if ($latestProjects->isEmpty())
                        <p class="text-sm text-gray-500">Belum ada project yang ditambahkan.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach ($latestProjects as $project)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $project->judul ?? $project->title }}</span>
                                        <span class="text-xs text-gray-500 block">
                                            Kategori: {{ $project->category->name ?? ($project->kategori ?? '-') }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-400">
                                        {{ $project->created_at ? $project->created_at->diffForHumans() : '' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>