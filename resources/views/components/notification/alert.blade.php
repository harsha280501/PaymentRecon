<div x-data='{
    open = true
}' style="position: absolute; bottom: 0; right: 3%; transform: translate(-3%, -0%); width: fit-content; z-index: 999999">
    @if (session()->has('message'))
    <div class="alert alert-primary d-flex align-items-center gap-2" style="padding: .7em 1em; width: 270px" role="alert">
        <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" role="img" aria-label="Warning:">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
            {{ session('message') }}
        </div>
    </div>
    @endif
</div>
