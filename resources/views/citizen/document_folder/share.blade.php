@extends('layouts.citizen')

@section('title', 'Folder')

@section('content')
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container mx-auto px-6">
    <div class="mb-4">
        <a href="{{ route('citizen.folder.index') }}" class="btn btn-sm btn-success">Kembali</a>
    </div>
    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">All Token</h1>
            <div class="overflow-x-auto text-center">
                <table class="table-auto w-full text-left">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Accessed</th>
                            <th class="px-4 py-2">Accessibility</th>
                            <th class="px-4 py-2">Active</th>
                            <th class="px-4 py-2">Expires at</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($folder->tokens) && $folder->tokens != null && $folder->tokens->count() > 0)
                            @php
                                $index = 1;
                            @endphp
                            @foreach($folder->tokens as $token)
                                <tr class="border-b">
                                    <td class="px-4 py-2 text-right">{{ $index++ }}</td>
                                    <td class="px-4 py-2">{{ $token->name }}</td>
                                    <td class="px-4 py-2">5</td>
                                    <td class="px-4 py-2">
                                        <div class="badge badge-sm badge-warning rounded-full">
                                            {{ $token->accessibility }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($token->expires_at == null || \Illuminate\Support\Carbon::now()->lte($token->expires_at))
                                            <div class="badge badge-success badge-sm">
                                                Active
                                            </div>
                                        @else
                                            <div class="badge badge-error badge-sm">
                                                Expired
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $token->expires_at ? \Illuminate\Support\Carbon::parse($token->expires_at)->format('j F Y H:i:s') : 'None' }}
                                    </td>
                                    <td class="px-4 py-2 space-x-2">
                                        <button class="btn btn-xs rounded-sm" onclick="my_modal_{{ $index }}.showModal()">
                                            Edit
                                        </button>
                                        <button class="btn btn-xs rounded-sm btn-primary" x-on:click="navigator.clipboard.writeText(`{{ route('citizen.token.show', ['token'=>$token->token]) }}`)
                                            .then(() => {
                                                alert('Text copied to clipboard!');
                                            })
                                            .catch(err => {
                                                console.error('Error copying text: ', err);
                                            });">
                                            Copy link
                                        </button>
                                        <button onclick="delete_modal_{{ $token->id }}.showModal()" class="btn btn-xs btn-error rounded-sm">
                                            delete
                                        </button>
                                        <dialog id="delete_modal_{{ $token->id }}" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Hapus Token</h3>
                                                <form action="{{ route('citizen.token.destroy', ['id'=>$token->id]) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <p class="mt-3">Yakin ingin menghapus token <span class="font-bold">{{ $token->name }}</span>?</p>
                                                    <div class="modal-action">
                                                        <button type="submit" class="btn btn-sm btn-primary">Yakin</button>
                                                        <button type="button" class="btn btn-sm" onclick="delete_modal_{{ $token->id }}.close()">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>
                                        <dialog id="my_modal_{{ $index }}" class="modal modal-bottom sm:modal-middle">
                                            <div class="modal-box">
                                                <h3 class="text-lg font-bold">Share Folder</h3>
                                                <form action="{{ route('citizen.token.update', ['id'=>$token->id]) }}" method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="folder_id" value="{{ $token->folder_id }}">
                                                    <div class="form-control mb-2 mt-2">
                                                        <label for="name">Name (optional)</label>
                                                        <input type="text" name="name" id="name" class="input input-sm input-bordered w-full mt-2" value="{{ $token->name }}">
                                                    </div>
                                                    <div class="form-control mb-2">
                                                        <label for="expires_at">Expires At (optional)</label>
                                                        <input type="datetime-local" name="expires_at" id="expires_at" @if($token->expires_at) value="{{ $token->expires_at }}" @endif class="mt-2 input input-sm input-bordered w-full" />
                                                    </div>
                                                    <div class="form-control mb-2">
                                                        <label for="accessibility">Accessibility</label>
                                                        <select id="accessibility" name="accessibility" class="mt-1 select select-sm select-bordered w-full" onchange="toggleCitizenContainer(event, {{ $token->id }})">
                                                            <option value="public" @selected($token->accessibility=='public')>Public</option>
                                                            <option value="restricted" @selected($token->accessibility=='restricted')>Restricted</option>
                                                        </select>
                                                    </div>
                                                    <div class="{{ $token->accessibility=='restricted' ? '' : 'hidden' }} w-full" id="authorized_citizen_container{{ $token->id }}">
                                                        <div class="w-full dropdown dropdown-bottom dropdown-end">
                                                            <label class="form-control w-full">
                                                                <div>Member</div>
                                                                <input type="text" id="memberSearchField" class="mt-2 input input-sm input-bordered w-full" autocomplete="off" oninput="search(event, {{ $token->id }})">
                                                            </label>
                                                            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-full p-0 shadow overflow-hidden">
                                                                <div class="p-2 w-full" id="inputMembersContainer{{ $token->id }}"></div>
                                                                <div class="bg-slate-200 text-center italic py-3">Search citizen will be displayed here</div>
                                                            </ul>
                                                        </div>
                                                        <ul id="membersContainer{{ $token->id }}" class="px-3 py-3 text-sm bg-base-200 rounded-md w-full mt-4">
                                                            @if(isset($token->authorized_citizens) && $token->authorized_citizens != null && $token->authorized_citizens->count() > 0)
                                                                @foreach ($token->authorized_citizens as $c)
                                                                    <li id="membershipList{{ $token->id }}_{{ $c->id }}" class="p-3 rounded-md">
                                                                        <div class="flex items-center justify-between">
                                                                            <input type='hidden' name='authorized_citizens[]' value='{{ $c->id }}'>
                                                                            <div>
                                                                                <div class='font-semibold'>{{ $c->name }}</div>
                                                                                <div class='font-thin text-xs'>{{ $c->nik }}</div>
                                                                            </div>
                                                                            <button type="button" class="btn btn-sm btn-error aspect-square rounded-sm" onclick="removeMemberFromList({{ $c->id }}, {{ $token->id }})">x</button>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
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
                                <td colspan="7" class="text-center py-4">Belum ada token</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-4 px-6 p-5">
                    {{-- {{ $folder->tokens->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const inputMembersContainer = document.getElementById("inputMembersContainer")

    const memberAddButtons = document.querySelectorAll('.memberAddButton');
    const accessToggleEl = document.getElementById('accessibility');
    const authorizedCitizensContainer = document.getElementById('authorized_citizen_container')

    const searchInterval = 500;
    let searchTimeout = null;
    let members = []
    let memberList = {}

    function toggleCitizenContainer(e, id) {
        const authorizedCitizensContainer = document.getElementById(`authorized_citizen_container${id}`)
        if(e.target.value == 'restricted') {
            authorizedCitizensContainer.classList.remove('hidden')
        } else {
            const containerClass = authorizedCitizensContainer.getAttribute('class');
            authorizedCitizensContainer.setAttribute('class', `${containerClass} hidden`)
        }
    }

    function search(e, id) {
        if(searchTimeout!=null) clearTimeout(searchTimeout);
        searchTimeout = setTimeout(()=>{searchCitizen('member', e.target.value, id)}, searchInterval);
    }

    function addMember(data,index,id) {
        if(memberList[id] == null) {
            memberList[id] = [];
        }
        let check = memberList[id].filter((m)=>m.id === data.id)
        if(check.length === 0) {
            const membersContainer = document.getElementById(`membersContainer${id}`)
            memberList[id].push(data)
            const newLi = document.createElement('li')
            newLi.setAttribute('class', "p-3 rounded-md")
            newLi.setAttribute('id', `membershipList${id}_${data.id}`)
            newLi.innerHTML+=`
            <div class="flex items-center justify-between">
                <input type='hidden' name='authorized_citizens[]' value='${data.id}'>
                <div>
                    <div class='font-semibold'>${data.name}</div>
                    <div class='font-thin text-xs'>${data.nik}</div>
                </div>
                <button type="button" class="btn btn-sm btn-error aspect-square rounded-sm" onclick="removeMemberFromList(${data.id}, ${id})">x</button>
            </div>`
            membersContainer.append(newLi);
            HideContainer(membersContainer, memberList[id]);
        }
    }

    function removeMemberFromList(id, tokenId) {
        if(memberList[tokenId] == null) {
            memberList[tokenId] = [];
        }
        const membersContainer = document.getElementById(`membersContainer${tokenId}`)
        memberList[tokenId] = memberList[tokenId].filter(m=>m.id!==id);
        document.getElementById(`membershipList${tokenId}_${id}`).remove();
        HideContainer(membersContainer, memberList[tokenId]);
    }

    function searchCitizen(type, value, id) {
        const limit = 4;
        const formData = new FormData();
        const nik = value
        const _token = document.querySelector("input[name='csrf-token']").getAttribute('value')
        formData.append('nik', nik);
        formData.append('limit', limit);
        formData.append('_token', _token);
        fetch('/dukcapil/citizen/search', {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            appendData(data, type, id);
        })
        .catch(err => {
            console.error('Error capturing content:', err);
        });
    }

    function appendData(data, type, id) {
        if(type === 'member') {
            const inputMembersContainer = document.getElementById(`inputMembersContainer${id}`)
            inputMembersContainer.innerHTML = '';
            members = data.citizens;
            members.forEach((m, i) => {
                const newLi = document.createElement('li')
                const button = document.createElement('button')
                button.setAttribute('type', 'button')
                button.addEventListener('click', ()=>{
                    addMember(m, i, id);
                    document.activeElement.blur()
                })
                button.innerHTML+=`
                    <div class='font-semibold'>${m.name}</div>
                    <div class='font-thin text-xs'>${m.nik}</div>`
                newLi.append(button)
                inputMembersContainer.append(newLi);
            })
        }
    }

    function HideContainer(container, list) {
        if(list.length === 0 && container.innerHTML.trim() === '') {
            container.classList.add('hidden');
        } else {
            container.classList.remove('hidden');
        }
    }
</script>
@endsection
