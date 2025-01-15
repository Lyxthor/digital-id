<nav class="p-4">
    <ul>
        <li class="mb-2">
            <a href="{{ route('dashboard.citizen') }}"
               class="block px-4 py-2 rounded {{ Route::is('dashboard.citizen') ? 'bg-primary text-white' : 'text-dark' }}">
                Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('citizen.document.index') }}"
               class="block px-4 py-2 rounded {{ Route::is('citizen.document.index') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
                Dokumen
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('citizen.folder.index') }}"
               class="block px-4 py-2 rounded {{ Route::is('citizen.folder.index') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
                Folder
            </a>
        </li>
        <li class="mb-2">
            <a href=""
               class="block px-4 py-2 rounded text-dark hover:bg-primary hover:text-white'">
                Event
            </a>
        </li>
        <li class="mb-2">
            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="block w-full text-left px-4 py-2 rounded text-dark hover:bg-primary hover:text-white">
                Logout
            </button>
            </form>
        </li>
    </ul>
</nav>
