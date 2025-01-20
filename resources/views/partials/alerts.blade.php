
<div class="container w-1/2 fixed top-8 right-8 z-20" id="alert-container">
    <div class="flex justify-end w-full">
        @session('error')
            <div
            role="alert"
            class="alert alert-error"
            x-data="{ show: true, fade: false }"
            x-show="show"
            :class="fade ? 'animate-fade-out' : 'animate-once-wiggle'"
            x-init="
            setTimeout(()=>fade = true,4000)
            setTimeout(()=>show = false,7000)">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 shrink-0 stroke-current"
                fill="none"
                viewBox="0 0 24 24">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endsession
        @session('success')
            <div
            role="alert"
            class="alert alert-success"
            x-data="{ show: true, fade: false }"
            x-show="show"
            :class="fade ? 'animate-fade-out' : 'animate-once-wiggle'"
            x-init="
            setTimeout(()=>fade = true,4000)
            setTimeout(()=>show = false,7000)">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 shrink-0 stroke-current"
                fill="none"
                viewBox="0 0 24 24">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endsession
    </div>
</div>


