<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@extends('template.index') {{-- pastikan ini layout dashboard kamu --}}
@section('main')
    <div class="container">
        {{-- Gambar Header --}}
        <div class="text-center mb-4">
            <!-- Judul Help -->
            <h2 class="fw-bold mb-2">Frequently Asked Questions</h2>
            <p class="text-muted mb-4">Deep Dive into our Knowledgebase</p>

            <!-- Gambar Help -->
            <img src="{{ asset('template/img/backgrounds/help.png') }}" alt="Help Banner" class="img-fluid rounded shadow">
        </div>



        {{-- Alasan isi logbook --}}
        <div class="card shadow-sm mb-4">
            <!-- Header Card -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Judul -->
                <h5 class="mb-0">Mengapa harus mengisi logbook?</h5>

                <!-- Icon dropdown di pojok kanan -->
                <i class="bi bi-chevron-down" id="iconChevron" style="cursor:pointer;" data-bs-toggle="collapse"
                    data-bs-target="#pdfLogbook"></i>
            </div>


            <!-- Collapse -->
            <div id="pdfLogbook" class="collapse">
                <div class="card-body" style="height: 650px;">
                    <!-- PDF.js Viewer -->
                    <iframe src="{{ asset('files/psbb-ur.pdf') }}" width="100%" height="600px"
                        style="border:none; border-radius:10px;">
                    </iframe>
                </div>
            </div>
        </div>

        {{-- Tombol WhatsApp --}}
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Did not find an answer? Send us a note!</h5>
                    <small class="text-muted">Kepegawaian Universitas Riau</small>
                </div>
                <a href="https://wa.me/6281246472767?text=Halo%20saya%20ingin%20bertanya%20tentang%20logbook"
                    target="_blank" class="btn btn-primary">
                    TELL KEPEGAWAIAN UNIVERSITAS RIAU
                </a>
            </div>
        </div>

    </div>
@endsection

<script>
    // Ganti ikon panah saat buka/tutup
    const collapse = document.getElementById('pdfLogbook');
    collapse.addEventListener('show.bs.collapse', () => {
        document.getElementById('iconChevron').classList.replace('bi-chevron-down', 'bi-chevron-up');
    });
    collapse.addEventListener('hide.bs.collapse', () => {
        document.getElementById('iconChevron').classList.replace('bi-chevron-up', 'bi-chevron-down');
    });
</script>
