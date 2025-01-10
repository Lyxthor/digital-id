<div class="fixed inset-y-0 left-0 z-30 w-64 bg-white shadow-lg transform transition-transform lg:translate-x-0 lg:static lg:inset-0">
    <div class="p-4 bg-primary text-white">
        <h1 class="text-xl font-bold">Citizen Dashboard</h1>
    </div>
    <nav class="p-4">
        <ul>
            <li class="mb-2"><a href="#"
                    class="block px-4 py-2 rounded bg-primary text-white">Dashboard</a></li>
            <li class="mb-2"><a href="#"
                    class="block px-4 py-2 rounded hover:bg-primary hover:text-white">Dokumen</a></li>
            <li class="mb-2"><a href="{{ route('citizen.folder.index') }}"
            <li class="mb-2"><a href="{{route('citizen.folder.index')}}"
                    class="block px-4 py-2 rounded hover:bg-primary hover:text-white">Folder</a></li>
            <li class="mb-2"><a href="#"
                    class="block px-4 py-2 rounded hover:bg-primary hover:text-white">Event</a></li>
        </ul>
    </nav>
</div>
