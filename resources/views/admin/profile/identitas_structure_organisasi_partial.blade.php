@if(isset($profile) && $profile->struktur_organisasi)
    <div class="mt-2">
        <div class="fw-bold mb-1">Preview Bagan Struktur</div>
        <img
            src="{{ asset('storage/'.$profile->struktur_organisasi) }}"
            alt="Preview struktur organisasi"
            class="img-thumbnail"
            style="max-width: 240px; max-height: 180px; object-fit: contain;"
        >
    </div>
@endif

