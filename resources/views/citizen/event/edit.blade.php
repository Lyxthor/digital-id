@extends('layouts.citizen')

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
                                <span class="text-xs mb-6 text-slate-500">Add new event</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('citizen.event.index') }}" class="btn btn-success">Back to index</a>
                    </div>
                </div>
                <form action="{{ route('citizen.event.update', ['id'=>$event->id]) }}" method="POST" >
                    @method('PUT')
                    @csrf
                    <div class="mb-6">
                        <label class="form-control w-full mb-3">
                            <div class="label">
                                <span class="label-text">Title</span>
                            </div>
                            <input type="text" name="title" id="title" class="input input-bordered w-full" value="{{ $event->title }}">
                        </label>
                        <div class="grid grid-cols-2 mb-4 gap-2 box-content">
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text">Submit deadline</span>
                                </div>
                                <input type="datetime-local" name="submit_deadline" id="submit_deadline" class="input input-sm input-bordered w-full" value="{{ $event->submit_deadline }}">
                            </label>
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text">Access deadline</span>
                                </div>
                                <input type="datetime-local" name="access_expires_at" id="access_expires_at" class="input input-sm input-bordered w-full" value="{{ $event->access_expires_at }}">
                            </label>
                        </div>
                        <label class="form-control w-full mb-3">
                            <div class="label">
                                <span class="label-text">Description</span>
                            </div>
                            <textarea name="desc" id="desc" cols="30" rows="3" class="textarea textarea-bordered">{{ $event->desc }}</textarea>
                        </label>
                        <label class="form-control w-full mb-4">
                            <div class="label">
                            <span class="label-text">Document Type</span>
                            </div>
                            <div class="flex w-full gap-2 flex-wrap">
                                @if(isset($document_types) && $document_types != null && $document_types->count() > 0)
                                @foreach ($document_types as $dt)
                                    <div>
                                        <input type="checkbox" name="document_requirements[]" id="document_requirements{{ $dt->id }}" class="hidden peer" value="{{ $dt->id }}" @checked($event->requirements->where('id', $dt->id)->isNotEmpty())>
                                        <label for="document_requirements{{ $dt->id }}" class="btn btn-sm rounded-badge peer-checked:btn-primary">{{ $dt->name }}</label>
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </label>
                        <div id="reviewer_container">
                            <div class="w-full dropdown dropdown-bottom dropdown-end">
                                <label class="form-control w-full">
                                    <div class="label">
                                        <span class="label-text">Reviewers</span>
                                    </div>
                                    <input type="text" id="memberSearchField" class=" mt-2 input input-bordered w-full" autocomplete="off">
                                </label>
                                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-full p-0 shadow overflow-hidden">
                                    <div class="p-2 w-full" id="inputMembersContainer"></div>
                                    <div class="bg-slate-200 text-center italic py-3">
                                        Search citizen will be displayed here
                                    </div>
                                </ul>
                            </div>
                            <ul id="membersContainer" class="px-3 py-3 text-sm bg-base-200 rounded-md w-full mt-4">


                                @if (isset($event->reviewers) && $event->reviewers != null && $event->reviewers->isNotEmpty())
                                @foreach ($event->reviewers as $rv)
                                <li class="p-3 rounded-md" id="membershipList{{ $rv->id }}">
                                    <div class="flex items-center justify-between">
                                        <input type='hidden' name='reviewers[]' value='{{ $rv->id }}'>
                                        <div>
                                            <div class='font-semibold'>{{ $rv->name }}</div>
                                            <div class='font-thin text-xs'>{{ $rv->nik }}</div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-error aspect-square rounded-sm" onclick="removeMemberFromList({{ $rv->id }})">
                                            x
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Simpan Perubahan</button>
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
    const accessToggleEl = document.getElementById('accessibility');
    const reviewerContainer = document.getElementById('reviewer_container')

    const searchInterval = 500;
    let searchTimeout = null;
    let members = []
    let memberList = []


    HideContainer(membersContainer, memberList);
    memberSearchField.addEventListener('input', ()=>{
        if(searchTimeout!=null) clearTimeout(searchTimeout);
        searchTimeout = setTimeout(()=>{searchCitizen('member')}, searchInterval);
    })


    function addMember(data,index)
    {
        let check = memberList.filter((m)=>m.id === data.id)
        if(check.length === 0)
        {
            memberList.push(data)
            const newLi = document.createElement('li')
            newLi.setAttribute('class', "p-3 rounded-md")
            newLi.setAttribute('id', `membershipList${data.id}`)
            newLi.innerHTML+=`
            <div class="flex items-center justify-between">
                <input type='hidden' name='reviewers[]' value='${data.id}'>
                <div>
                    <div class='font-semibold'>${data.name}</div>
                    <div class='font-thin text-xs'>${data.nik}</div>
                </div>
                <button type="button" class="btn btn-sm btn-error aspect-square rounded-sm" onclick="removeMemberFromList(${data.id})">
                        x
                </button>
            </div>`
            membersContainer.append(newLi);
            HideContainer(membersContainer, memberList);
        }
    }
    function removeMemberFromList(id)
    {
        memberList = memberList.filter(m=>m.id!==id);
        document.getElementById(`membershipList${id}`).remove();
        HideContainer(membersContainer, memberList);

    }
    function searchCitizen(type)
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
            appendData(data, type);
        })
        .catch(err => {
            console.error('Error capturing content:', err);
        });
    }
    function appendData(data, type)
    {
        if(type === 'member')
        {
            inputMembersContainer.innerHTML = '';
            members = data.citizens;
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

    }
    function HideContainer(container, list)
    {
        if(list.length === 0 && container.innerHTML.trim() === '')
        {
            container.classList.add('hidden');
        }
        else
        {
            container.classList.remove('hidden');
        }
    }
</script>
@endsection
