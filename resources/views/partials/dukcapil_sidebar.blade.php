<nav class="p-4">
    <ul>
        <li class="mb-2">
            <li class="mb-2">
                <a href="{{ route('dashboard.dukcapil') }}"
                   class="block px-4 py-2 rounded {{ Route::is('dashboard.dukcapil') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}'">
                    Dashboard
                </a>
            </li>
        </li>
        <li class="mb-2">
            <a href="{{ route('dukcapil.citizen.index') }}"
               class="block px-4 py-2 rounded {{ Route::is('dukcapil.citizen.index') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}'">
                Citizen
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('dukcapil.document_type.index') }}"
               class="block px-4 py-2 rounded {{ Route::is('dukcapil.document_type.index') ? 'bg-primary text-white' : 'text-dark hover:bg-primary hover:text-white' }}'">
                Document Type
            </a>
        </li>
        <li class="mb-2">
            <button
            type="submit"
            class="block w-full text-left px-4 py-2 rounded text-dark hover:bg-primary hover:text-white"
            onclick="logout_modal.showModal()">
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
