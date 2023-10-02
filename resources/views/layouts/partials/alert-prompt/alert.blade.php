@if (session('success'))
    <div class="alert border-0 border-success border-start border-4 bg-light-success alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i></div>
            <div class="ms-3">
                <div class="text-success">{{ session('success') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- @if (session('error'))
    <div class="alert border-0 border-danger border-start border-4 bg-light-danger alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i></div>
            <div class="ms-3">
                <div class="text-danger">{{ session('error') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif --}}

@if ($errors->any())
    <div class="alert border-0 border-danger border-start border-4 bg-light-danger alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i></div>
            <div class="ms-3">
                <div class="text-danger">Terjadi kesalahan. Silakan periksa dan coba lagi.</div>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if (session('warning'))
    <div class="alert border-0 border-warning border-start border-4 bg-light-warning alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="ms-3">
                <div class="text-warning">{{ session('warning') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert border-0 border-info border-start border-4 bg-light-info alert-dismissible fade show py-2">
        <div class="d-flex align-items-center">
            <div class="fs-3 text-info"><i class="bi bi-info-circle-fill"></i></div>
            <div class="ms-3">
                <div class="text-info">{{ session('info') }}</div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Tambahkan jQuery di bawah Bootstrap atau sebelum kode Anda -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Fungsi untuk menghilangkan alert setelah 3 detik
    $(document).ready(function() {
        $(".alert").delay(3000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>
