@extends('template.index')

@section('title', 'Dashboard AdminCraft')
<!-- Content -->
@section('main')
    <div class="row">
        <div class="col-xxl-8 mb-6 order-0">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Selamat Datang {{ Auth::user()->name }}</h5>
                            <p class="mb-6">Yuk, lanjutkan aktivitasmu hari ini dan<br /> Jangan lupa isi Logbook.</p>
                            <p style="color: rgb(165, 51, 6)">Mulailah hari dengan niat baik dan semangat baru 🌞</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                            <img src="{{ asset('template/img/illustrations/man-with-laptop.png') }}" height="175"
                                alt="View Badge User" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
            {{-- 2kotak --}}
            <div class="row">
                <div class="col-12 mb-6">
                    <div class="card h-100" style="display: flex; flex-direction: row; align-items: stretch; width: 100%;">

                        <!-- Bagian kiri: Jumlah Hadir Hari Ini -->
                        <div class="card-body" style="width: 50%; border-right: 1px solid #ddd; text-align: center;">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4"></div>
                            <p class="mb-1" style="font-weight: 600;">Jumlah Hadir Hari Ini</p>

                            <!-- 🔹 Tambahkan ID agar bisa di-update lewat JS -->
                            <h4 class="card-title mb-3" id="hadir-count" style="font-size: 1.8rem; color: #28a745;">
                                {{ $hadirHariIni ?? 0 }} Orang
                            </h4>

                            <small class="text-muted">Update otomatis setiap hari</small>
                        </div>

                        <!-- Bagian kanan: Tidak Hadir Hari Ini -->
                        <div class="card-body" style="width: 50%; text-align: center;">
                            <div class="card-title d-flex align-items-start justify-content-between mb-4"></div>
                            <p class="mb-1" style="font-weight: 600;">Tidak Hadir Hari Ini</p>

                            <!-- 🔹 Tambahkan ID juga di sini -->
                            <h4 class="card-title mb-3" id="tidak-hadir-count" style="font-size: 1.8rem; color: #dc3545;">
                                {{ $tidakHadirHariIni ?? 0 }} Orang
                            </h4>

                            <small class="text-muted">Update otomatis setiap hari</small>
                        </div>

                    </div>
                </div>
            </div>

            <!-- 🔹 Tambahkan script di bawah (bisa di section scripts atau langsung di bawah konten) -->
            <script>
                function updateHadirData() {
                    fetch("{{ route('admin.hadirHariIni') }}") // route yang kita tambahkan di web.php
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById("hadir-count").textContent = data.hadirHariIni + " Orang";
                            document.getElementById("tidak-hadir-count").textContent = data.tidakHadirHariIni + " Orang";
                        })
                        .catch(error => console.error('Gagal memuat data:', error));
                }

                // 🔁 Jalankan pertama kali saat halaman dibuka
                updateHadirData();

                // 🔁 Lalu update otomatis setiap 10 detik
                setInterval(updateHadirData, 10000);
            </script>


        </div>
    </div>
    <div class="row">

        <!-- jumlah pegawai -->
<div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
    <div class="card h-100">
        <div class="card-header text-center">
            <h5 class="mb-1 me-2">Jumlah Pegawai Universitas Riau</h5>
            <p class="card-subtitle">Berdasarkan tipe pegawai</p>
        </div>
        <div class="card-body">
            <!-- Chart di Tengah -->
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div id="pegawaiChart" style="height: 250px;"></div>
            </div>

            <ul class="p-0 m-0">
                <li class="d-flex align-items-center mb-4">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="icon-base bx bx-user"></i>
                        </span>
                    </div>
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <h6 class="mb-0">PNS</h6>
                        <h6 class="mb-0">{{ number_format($jumlahPNS) }}</h6>
                    </div>
                </li>
                <li class="d-flex align-items-center mb-4">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="icon-base bx bx-id-card"></i>
                        </span>
                    </div>
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <h6 class="mb-0">P3K</h6>
                        <h6 class="mb-0">{{ number_format($jumlahP3K) }}</h6>
                    </div>
                </li>
                <li class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="icon-base bx bx-group"></i>
                        </span>
                    </div>
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <h6 class="mb-0">PHL</h6>
                        <h6 class="mb-0">{{ number_format($jumlahPHL) }}</h6>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--/ jumlah pegawai -->

<!-- Chart Script -->
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: [{{ $jumlahPNS }}, {{ $jumlahP3K }}, {{ $jumlahPHL }}],
            chart: {
                height: 250, // ✅ disamakan dengan chart logbook (lebih proporsional)
                type: 'donut',
            },
            labels: ['PNS', 'P3K', 'PHL'],
            colors: ['#ff4560', '#ffb84d', '#00E396'],
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '68%', // ✅ sama dengan chart logbook biar seragam
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                color: '#333',
                                formatter: () =>
                                    '{{ number_format($jumlahPNS + $jumlahP3K + $jumlahPHL) }}'
                            }
                        }
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#pegawaiChart"), options);
        chart.render();
    });
</script>
@endpush


        <!-- Persentase Pengisian Logbook -->
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
            <div class="card h-100">
                <div class="card-header text-center">
                    <h5 class="mb-1 me-2">Persentase Pengisian Logbook</h5>
                    <p class="card-subtitle">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</p>
                    <small>(Persentase update otomatis, realtime setiap hari)</small>
                </div>

                <div class="card-body text-center">
                    <!-- Chart container -->
                    <div id="logbookChart" style="height: 250px;"></div>

                    <ul class="list-unstyled text-start mx-auto mt-3" style="max-width: 250px;">
                        <li class="d-flex align-items-center mb-2">
                            <span class="badge rounded-pill me-2" style="background-color: #00E396;">&nbsp;</span>
                            <span>{{ $usersTerisi }} Logbook terisi</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <span class="badge rounded-pill me-2" style="background-color: #FF4560;">&nbsp;</span>
                            <span>{{ $usersBelumIsi }} Logbook tidak terisi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



        <!-- laporan -->
        <div class="col-md-6 col-lg-4 order-2 mb-6">
            <div class="card h-100">
                <div class="card-header text-center">
                    <h5 class="mb-1 me-2">Persentase Laporan</h5>
                    <p class="card-subtitle">Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}</p>
                    <small>(Data realtime per hari)</small>
                </div>

                <div class="card-body text-center">
                    <div id="persentaseLaporanChart" style="height: 250px;"></div>

                    <ul class="list-unstyled text-start mx-auto mt-3" style="max-width: 250px;">
                        <li class="d-flex align-items-center mb-2">
                            <span class="badge rounded-pill me-2" style="background-color: #008FFB;">&nbsp;</span>
                            <span>{{ $persenDL ?? 0 }}% Dinas Luar</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="badge rounded-pill me-2" style="background-color: #00E396;">&nbsp;</span>
                            <span>{{ $persenHadir ?? 0 }}% Hadir</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <span class="badge rounded-pill me-2" style="background-color: #FEB019;">&nbsp;</span>
                            <span>{{ $persenCuti ?? 0 }}% Cuti</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <span class="badge rounded-pill me-2" style="background-color: #FF4560;">&nbsp;</span>
                            <span>{{ $persenSakit ?? 0 }}% Sakit</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <!--/ laporan -->
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // === Persentase Pengisian Logbook (chart pertama) ===
            var logbookChart = new ApexCharts(document.querySelector("#logbookChart"), {
                series: [{{ $persentaseIsi }}, {{ $persentaseTidakIsi }}],
                chart: {
                    height: 250, // 🔹 sedikit lebih besar agar seimbang
                    type: 'donut',
                },
                labels: ['Terisi', 'Tidak isi'],
                colors: ['#00E396', '#FF4560'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '68%', // 🔹 lebih besar dan proporsional, tapi tidak berlebihan
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: '{{ round($persentaseTidakIsi, 1) }}%',
                                    fontSize: '17px',
                                    fontWeight: 600,
                                    color: '#000',
                                    formatter: () => 'Tidak isi' // 🔹 tetap seperti aslinya
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true, // 🔹 aktifkan label persen di garis lingkaran
                    formatter: function(val, opts) {
                        return val.toFixed(1) + "%";
                    },
                    style: {
                        fontSize: '13px',
                        fontWeight: 600,
                        colors: ['#fff'] // 🔹 semua tulisan persen jadi putih
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        opacity: 0.5
                    }
                },
                legend: {
                    show: false
                }
            });

            logbookChart.render();


            // === Persentase Laporan (chart kedua) ===
            var dl = {{ $persenDL ?? 0 }};
            var hadir = {{ $persenHadir ?? 0 }};
            var cuti = {{ $persenCuti ?? 0 }};
            var sakit = {{ $persenSakit ?? 0 }};

            var total = dl + hadir + cuti + sakit;

            var seriesData = total === 0 ? [1] : [dl, hadir, cuti, sakit];
            var labelData = total === 0 ? ['Tidak Ada Data'] : ['Dinas Luar', 'Hadir', 'Cuti', 'Sakit'];
            var colorData = total === 0 ? ['#E5E7EB'] : ['#008FFB', '#00E396', '#FEB019', '#FF4560'];

            var laporanChart = new ApexCharts(document.querySelector("#persentaseLaporanChart"), {
                series: seriesData,
                chart: {
                    height: 250,
                    type: 'donut'
                },
                labels: labelData,
                colors: colorData,
                dataLabels: {
                    enabled: total !== 0, // matikan label kalau 0 semua
                    formatter: (val) => val.toFixed(1) + "%"
                },
                legend: {
                    show: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '14px',
                                    offsetY: 20 // 🔽 tambah jarak ke bawah
                                },
                                value: {
                                    show: true,
                                    fontSize: '18px',
                                    offsetY: -15, // 🔼 geser sedikit ke atas biar gak nempel
                                    formatter: function() {
                                        return total === 0 ? '0%' : hadir + '%';
                                    }
                                },
                                total: {
                                    show: true,
                                    label: total === 0 ? 'Belum Ada Data' : 'Hadir',
                                    fontSize: '13px',
                                    offsetY: 0, // netral, biar rapi di tengah
                                    formatter: function() {
                                        return total === 0 ? '' : '{{ $hadir ?? 0 }}';
                                    }
                                }
                            }
                        }
                    }
                }
            });

            laporanChart.render();


        });
    </script>
@endpush
