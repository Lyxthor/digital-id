<nav class="p-4">
    <ul>
        <li class="mb-2">
            <a href="{{ route('dashboard.citizen') }}"
               class="flex gap-2 px-4 py-2 rounded {{ Route::is('dashboard.citizen')  ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
            </svg>
                Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('citizen.document.index') }}"
               class="flex gap-2 px-4 py-2 rounded {{ Route::is('citizen.document.*') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
              </svg>
                Dokumen
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('citizen.folder.index') }}"
               class="flex gap-2 px-4 py-2 rounded {{ Route::is('citizen.folder.*') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">

               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
              </svg>

                Folder
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('citizen.event.index') }}"
               class="flex gap-2 px-4 py-2 rounded {{ Route::is('citizen.event.*') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}'">

               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
              </svg>

                Event
            </a>
        </li>
        <li class="mb-2">
            <button
            type="submit"
            class="flex gap-2 w-full text-left px-4 py-2 rounded text-dark hover:bg-primary hover:text-white"
            onclick="logout_modal.showModal()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
            </svg>
            Logout
        </button>
            <dialog id="logout_modal" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Logout</h3>
                    <form
                    action="{{ route('logout') }}"
                    method="post">

                        @csrf
                        <p class="mt-3">Yakin ingin keluar dari aplikasi?</p>
                        <div class="modal-action">
                            <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                            <button type="button" class="btn btn-sm" onclick="logout_modal.close()">Batal</button>
                        </div>
                    </form>
                </div>
            </dialog>
        </li>
    </ul>
</nav>
