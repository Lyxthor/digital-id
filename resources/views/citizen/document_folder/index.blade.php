@extends('layouts.citizen')

@section('title', 'Folder')

@section('content')
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container mx-auto px-6">
    {{-- Form create folder --}}
    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="p-6">
            <h2 class="text-lg font-bold capitalize mb-4">Folder Saya</h2>
            <form action="{{ route('citizen.folder.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Masukkan Nama Folder"
                    class="input input-bordered input-sm px-10" value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-primary ml-2">Search</button>
            </form>
            <form action="{{ route('citizen.folder.store') }}" method="POST" class="flex items-center justify-end gap-2 mb-4">
                @csrf
                <input type="hidden" name="category" id="category" value="preMade">
                <div class="flex items-center gap-2">
                    <input type="text" name="name" placeholder="Tambahkan Folder baru" class="input input-bordered input-sm w-1/2" required>
                    <button type="submit" class="btn btn-sm btn-primary">Buat Folder</button>
                </div>
            </form>
            <div class="overflow-x-auto text-center">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Document</th>
                            <th class="px-4 py-2">Last Modified</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($folders) && $folders != null && $folders->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach($folders as $folder)
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-right">{{ $index++ }}</td>
                                    <td class="px-4 py-2"><a href="{{ route('citizen.folder.edit', ['id' => $folder->id]) }}">{{ $folder->name }}</a></td>
                                    <td class="px-4 py-2">{{ $folder->updated_at }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <button onclick="delete_modal_{{ $folder->id }}.showModal()" class="btn btn-xs btn-error rounded-sm">Delete</button>
                                        <dialog id="delete_modal_{{ $folder->id }}" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Hapus Dokumen</h3>
                                                <form action="{{ route('citizen.folder.destroy', ['id' => $folder->id]) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <p class="mt-3">Yakin ingin menghapus folder <span class="font-bold">{{ $folder->name }}</span>?</p>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                                                        <button type="button" class="btn btn-sm" onclick="delete_modal_{{ $folder->id }}.close()">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>
                                        <a href="{{ route('citizen.folder.edit', ['id' => $folder->id]) }}" class="btn btn-xs btn-warning rounded-sm">Edit</a>
                                        <a href="{{ route('citizen.folder.show', ['id' => $folder->id]) }}" class="btn btn-xs btn-success rounded-sm">Show</a>
                                        <button class="btn btn-xs btn-info rounded-sm" onclick="my_modal_{{ $index }}.showModal()">Share</button>
                                        <a href="{{ route('citizen.folder.share', ['id' => $folder->id]) }}" class="btn btn-xs btn-accent rounded-sm">View Token</a>
                                        <dialog id="my_modal_{{ $index }}" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Share Folder</h3>
                                                <form action="{{ route('citizen.token.store') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="folder_id" id="folder_id" value="{{ $folder->id }}">
                                                    <div class="form-control mb-2 mt-2">
                                                        <label for="name">Name (optional)</label>
                                                        <input type="text" name="name" id="name" class="input input-sm input-bordered w-full mt-2">
                                                    </div>
                                                    <div class="form-control mb-2">
                                                        <label for="expires_at">Expires At (optional)</label>
                                                        <input type="datetime-local" name="expires_at" id="expires_at" class="mt-2 input input-sm input-bordered w-full">
                                                    </div>
                                                    <div class="form-control mb-2">
                                                        <label for="accessibility">Accessibility</label>
                                                        <select name="accessibility" id="accessibility" class="mt-1 select select-sm select-bordered w-full">
                                                            <option value="public">Public</option>
                                                            <option value="restricted">Restricted</option>
                                                        </select>
                                                    </div>
                                                    <div class="hidden w-full" id="authorized_citizen_container">
                                                        <div class="w-full dropdown dropdown-bottom dropdown-end">
                                                            <label class="form-control w-full">
                                                                <div>Member</div>
                                                                <input type="text" id="memberSearchField" class="mt-2 input input-sm input-bordered w-full rounded-sm" autocomplete="off">
                                                            </label>
                                                            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-sm z-[1] w-full p-0 shadow overflow-hidden">
                                                                <div class="p-2 w-full" id="inputMembersContainer"></div>
                                                                <div class="bg-slate-200 text-center italic py-3">
                                                                    Search citizen will be displayed here
                                                                </div>
                                                            </ul>
                                                        </div>
                                                        <ul id="membersContainer" class="px-3 py-3 text-sm bg-base-200 rounded-md w-full mt-4"></ul>
                                                    </div>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                        <button type="button" class="btn btn-sm" onclick="my_modal_{{ $index }}.close()">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="py-2 text-center bg-stone-100">Belum ada document</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-4 px-6 p-5">
                    {{ $folders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputMembersContainer = document.getElementById("inputMembersContainer");
    const memberSearchField = document.getElementById("memberSearchField");
    const membersContainer = document.getElementById("membersContainer");
    const accessToggleEl = document.getElementById('accessibility');
    const authorizedCitizensContainer = document.getElementById('authorized_citizen_container');

    const searchInterval = 500;
    let searchTimeout = null;
    let members = [];
    let memberList = [];

    HideContainer(membersContainer, memberList);
    accessToggleEl.addEventListener('change', (e) => {
        if (e.target.value == 'restricted') {
            authorizedCitizensContainer.classList.remove('hidden');
        } else {
            const containerClass = authorizedCitizensContainer.getAttribute('class');
            authorizedCitizensContainer.setAttribute('class', `${containerClass} hidden`);
        }
    });
    memberSearchField.addEventListener('input', () => {
        if (searchTimeout != null) clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => { searchCitizen('member') }, searchInterval);
    });

    function addMember(data, index) {
        let check = memberList.filter((m) => m.id === data.id);
        if (check.length === 0) {
            memberList.push(data);
            const newLi = document.createElement('li');
            newLi.setAttribute('class', "p-3 rounded-md");
            newLi.setAttribute('id', `membershipList${data.id}`);
            newLi.innerHTML += `
            <div class="flex items-center justify-between">
                <input type='hidden' name='authorized_citizens[]' value='${data.id}'>
                <div>
                    <div class='font-semibold'>${data.name}</div>
                    <div class='font-thin text-xs'>${data.nik}</div>
                </div>
                <button type="button" class="btn btn-sm btn-error aspect-square rounded-sm" onclick="removeMemberFromList(${data.id})">
                        x
                </button>
            </div>`;
            membersContainer.append(newLi);
            HideContainer(membersContainer, memberList);
        }
    }

    function removeMemberFromList(id) {
        memberList = memberList.filter(m => m.id !== id);
        HideContainer(membersContainer, memberList);
        document.getElementById(`membershipList${id}`).remove();
    }

    function searchCitizen(type) {
        const limit = 4;
        const formData = new FormData();
        const nik = memberSearchField.value;
        const _token = document.querySelector("input[name='csrf-token']").getAttribute('value');
        formData.append('nik', nik);
        formData.append('limit', limit);
        formData.append('_token', _token);
        fetch('/dukcapil/citizen/search', {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            appendData(data, type);
        })
        .catch(err => {
            console.error('Error capturing content:', err);
        });
    }

    function appendData(data, type) {
        if (type === 'member') {
            inputMembersContainer.innerHTML = '';
            members = data.citizens;
            members.forEach((m, i) => {
                const newLi = document.createElement('li');
                const button = document.createElement('button');
                button.setAttribute('type', 'button');
                button.addEventListener('click', () => {
                    addMember(m, i);
                    document.activeElement.blur();
                });
                button.innerHTML += `
                    <div class='font-semibold'>${m.name}</div>
                    <div class='font-thin text-xs'>${m.nik}</div>`;
                newLi.append(button);
                inputMembersContainer.append(newLi);
            });
        }
    }

    function HideContainer(container, list) {
        if (list.length === 0) {
            container.classList.add('hidden');
        } else {
            container.classList.remove('hidden');
        }
    }
</script>
@endsection
