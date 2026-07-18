<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>{{ $title }}</h2>

            @isset($subtitle)
                <p class="text-muted mb-0">{{ $subtitle }}</p>
            @endisset
        </div>

        @isset($action)
            {{ $action }}
        @endisset

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{ $slot }}

</div>