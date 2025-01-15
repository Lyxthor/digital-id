@extends('layouts.citizen')

@section('title', 'Folder')


@section('content')
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Folder Saya</h1>

    {{-- Form create folder --}}
    <form action="{{route('citizen.folder.store')}}" method="POST" class="mb-4">
        @csrf
        <div class="flex items-center gap-2">
            <input type="hidden" name="category" id="category" value="preMade">
            <input type="text" name="name" placeholder="Tambahkan Folder baru" class="input input-bordered w-full" required>
            <button type="submit" class="btn btn-primary">Buat Folder</button>
        </div>
    </form>
    <div>
        <div class="container mx-auto h-96">
            <div class="card bg-white h-full">
                <table class="table table-xs">
                    <thead>
                      <tr>
                        <th class="py-5"></th>
                        <th class="border-r">Document</th>
                        <th class="border-r">Last Modified</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (isset($folders) && $folders!=null && $folders->count() > 0)
                        @php
                            $index = 1;
                        @endphp
                        @foreach($folders as $folder)
                            <tr>
                                <th>{{ $index++ }}</th>
                                <td><a href="{{ route('citizen.folder.edit', ['id'=>$folder->id]) }}">{{ $folder->name }}</a></td>
                                <td>
                                    {{ $folder->updated_at }}
                                </td>
                                <td>
                                    <button class="btn btn-sm" onclick="my_modal_{{ $index }}.showModal()">share</button>
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
                                                            <input type="text" id="memberSearchField" class=" mt-2 input input-sm input-bordered w-full" autocomplete="off">
                                                        </label>
                                                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-full p-0 shadow overflow-hidden">
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
                                                    <button class="btn btn-sm" onclick="my_modal_{{ $index }}.close()">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </dialog>
                                </td>
                            </tr>
                        @endforeach
                      @else
                        <tr>
                            <td colspan="4" class="py-2 text-center bg-stone-100">
                                Belum ada document
                            </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
            </div>
        </div>
    </div>


</div>
<script>
    const inputMembersContainer = document.getElementById("inputMembersContainer")
    const memberSearchField = document.getElementById("memberSearchField");
    const membersContainer = document.getElementById("membersContainer");
    const memberAddButtons = document.querySelectorAll('.memberAddButton');
    const accessToggleEl = document.getElementById('accessibility');
    const authorizedCitizensContainer = document.getElementById('authorized_citizen_container')
    console.log(memberSearchField)

    const searchInterval = 500;
    let searchTimeout = null;
    let members = []

    // memberAddButtons.forEach((el)=>{
    //     el.addEventListener('click', ()=>{
    //         addMember();
    //         document.activeElement.blur()
    //     })
    // })
    accessToggleEl.addEventListener('change', (e)=>{
        if(e.target.value == 'restricted'){

            authorizedCitizensContainer.classList.remove('hidden')
        }
        else
        {
            const containerClass = authorizedCitizensContainer.getAttribute('class');
            authorizedCitizensContainer.setAttribute('class', `${containerClass} hidden`)
        }
    })
    memberSearchField.addEventListener('input', ()=>{
        if(searchTimeout!=null) clearTimeout(searchTimeout);

        searchTimeout = setTimeout(searchCitizen, searchInterval);
    })
    function addMember(data,index)
    {
        const newLi = document.createElement('li')
        newLi.setAttribute('class', "p-3 rounded-md")
        newLi.innerHTML+=`
        <div class="flex items-center justify-between">
            <input type='hidden' name='authorized_citizens[]' value='${data.id}'>
            <div>
                <div class='font-semibold'>${data.name}</div>
                <div class='font-thin text-xs'>${data.nik}</div>
            </div>
        </div>`
        membersContainer.append(newLi);
    }
    function searchCitizen()
    {
        const limit = 4;
        const formData = new FormData();
        const nik = memberSearchField.value
        const _token = document.querySelector("input[name='csrf-token']").getAttribute('value')
        formData.append('nik', nik);
        formData.append('limit', limit);
        formData.append('_token', _token);
        fetch('/dukcapil/citizen/search',
        {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            members = data.citizens;
            appendData();
        })
        .catch(err => {
            console.error('Error capturing content:', err);
        });
    }
    function appendData()
    {
        inputMembersContainer.innerHTML = '';
        members.forEach((m, i) => {

            const newLi = document.createElement('li')
            const button = document.createElement('button')
            button.setAttribute('type', 'button')
            button.addEventListener('click', ()=>{
                addMember(m, i);
                document.activeElement.blur()
            })
            // newLi.setAttribute('class', "flex justify-between items-center py-2")
            button.innerHTML+=`
                <div class='font-semibold'>${m.name}</div>
                <div class='font-thin text-xs'>${m.nik}</div>`
            newLi.append(button)
            inputMembersContainer.append(newLi);
        })
    }
</script>
@endsection
