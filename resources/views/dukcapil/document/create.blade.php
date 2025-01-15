@extends('layouts.dukcapil')

@section('title', 'Add Citizen')

@section('content')
<input type="hidden" name="csrf-token" value="{{ csrf_token() }}">
<div class="container flex justify-center">
    <div class="w-1/2">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-end flex-wrap">
                    <div class="breadcrumbs w-full text-sm">
                        <ul>
                            <li><a>Home</a></li>
                            <li><a>Documents</a></li>
                            <li>Add Document</li>
                        </ul>
                    </div>
                    <div>
                        <div class="flex items-end gap-5">
                            <div>
                                <h2 class="card-title font-bold">Citizen Form</h2>
                                <span class="text-xs mb-6 text-slate-500">Add new document</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('dukcapil.document.index') }}" class="btn btn-success">Back to index</a>
                    </div>
                </div>
                <form action="{{ route('dukcapil.document.generate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="form-control w-full">
                            <div class="label">
                            <span class="label-text">Document Type</span>
                            </div>
                            <select type="text" name="type_id" id="type_id" placeholder="Type here" class="input input-bordered w-full">
                                @foreach ($types as $dt)
                                    <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <div class="w-full dropdown dropdown-bottom dropdown-end">
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Owner</span>
                                </div>
                                <input type="text" name="owner_id" id="owner_id" class="input input-bordered w-full">
                            </label>
                            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-full p-2 shadow">
                                <li><a>Item 1</a></li>
                                <li><a>Item 2</a></li>
                            </ul>
                        </div>
                        <ul id="" class="px-3 py-3 text-sm bg-base-200 rounded-md w-full mt-4">

                        </ul>
                        <div class="w-full dropdown dropdown-bottom dropdown-end">
                            <label class="form-control w-full">
                                <div class="label">
                                    <span class="label-text">Member</span>
                                </div>
                                <input type="text" id="memberSearchField" class="input input-bordered w-full" autocomplete="off">
                            </label>
                            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-full p-0 shadow overflow-hidden">
                                <div class="p-2 w-full" id="inputMembersContainer">

                                </div>
                                <div class="bg-slate-200 text-center italic py-3">
                                    Search citizen will be displayed here
                                </div>
                            </ul>
                        </div>
                        <ul id="membersContainer" class="px-3 py-3 text-sm bg-base-200 rounded-md w-full mt-4">

                        </ul>
                    </div>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Buy Now</button>
                    </div>
                </form>
            </div>
          </div>
    </div>
</div>
<script>
    const inputMembersContainer = document.getElementById("inputMembersContainer")
    const memberSearchField = document.getElementById("memberSearchField");
    const membersContainer = document.getElementById("membersContainer");
    const memberAddButtons = document.querySelectorAll('.memberAddButton');
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
            <input type='hidden' name='memberships[${index}][id]' value='${data.id}'>
            <div>
                <div class='font-semibold'>${data.name}</div>
                <div class='font-thin text-xs'>${data.nik}</div>
            </div>
            <div class="join text-black">
                <label class="input input-sm input-bordered flex items-center gap-2 join-item">
                    <span class="font-semibold">Role</span>
                    <input type="text" name='memberships[${index}][role]' class="grow text-xs text-slate-600" placeholder="NA" />
                </label>
                <button type="button" class="btn btn-sm btn-error aspect-square join-item">
                    x
                </button>
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
