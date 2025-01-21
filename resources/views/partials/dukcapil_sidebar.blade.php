<nav class="p-4">
    <ul>
        <li class="mb-2">
            <a href="{{ route('dashboard.dukcapil') }}"
               class="flex gap-2 items-center px-4 py-2 rounded {{ Route::is('dashboard.dukcapil') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
            </svg>
            Dashboard

            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('dukcapil.citizen.index') }}"
               class="flex gap-2 px-4 py-2 rounded {{ Route::is('dukcapil.citizen.*') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
              </svg>
                Citizen
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('dukcapil.document_type.index') }}"
               class="flex gap-2 px-4 py-2 rounded {{ Route::is('dukcapil.document_type.*') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
              </svg>

                Document Type
            </a>
        </li>
        <li class="mb-2">
            <button type="submit"
                    class="flex gap-2 items-center w-full text-left px-4 py-2 rounded text-dark hover:bg-primary hover:text-white"
                    onclick="logout_modal.showModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                      </svg>

                Logout
            </button>
            <dialog id="logout_modal" class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                    <h3 class="text-lg font-bold">Logout</h3>
                    <form action="{{ route('logout') }}" method="post">
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
