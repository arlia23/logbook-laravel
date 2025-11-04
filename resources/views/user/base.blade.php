@extends('template.index')

@section('title', 'Dashboard AdminCraft')

@section('main')
    <div class="row">
        {{-- KOLOM KIRI --}}
        <div class="col-xxl-8">
            {{-- kotak awal --}}
            <div class="mb-4">
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

            {{-- Grafik Order & Income --}}
            <div class="row">
                <!-- Persentase Laporan -->
              <div class="col-md-6 mb-4">
  <div class="card h-100 shadow-sm border-0">
    <div class="card-header text-center border-0 bg-white">
      <h5 class="mt-3 fw-semibold">Persentase Laporan</h5>
      <h6 class="text-primary mt-1">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h6>
    </div>

    <div class="card-body text-center d-flex flex-column align-items-center justify-content-center" style="margin-top: -10px;">
      <div class="chart-container position-relative" style="width:250px; height:250px; margin-top:-17px;">
        <canvas id="laporanChart"></canvas>
        <div id="laporanCenter"
          class="position-absolute top-50 start-50 translate-middle text-center">
          <div id="laporanLabel" class="fw-semibold text-secondary small">Hadir</div>
          <div id="laporanValue" class="fw-bold fs-5 text-success">{{ $persenHadir ?? 0 }}%</div>
        </div>
      </div>

      <div class="mt-4">
        <ul class="list-unstyled d-inline-block text-start">
  <li class="laporan-item mb-2" data-type="Hadir" data-value="{{ $persenHadir ?? 0 }}">
    <span class="badge rounded-pill" style="background-color:#6EE7B7;">&nbsp;&nbsp;</span> Hadir
  </li>
  <li class="laporan-item mb-2" data-type="Dinas Luar" data-value="{{ $persenDL ?? 0 }}">
    <span class="badge rounded-pill" style="background-color:#93C5FD;">&nbsp;&nbsp;</span> Dinas Luar
  </li>
  <li class="laporan-item mb-2" data-type="Cuti" data-value="{{ $persenCuti ?? 0 }}">
    <span class="badge rounded-pill" style="background-color:#D1D5DB;">&nbsp;&nbsp;</span> Cuti
  </li>
  <li class="laporan-item mb-2" data-type="Sakit" data-value="{{ $persenSakit ?? 0 }}">
    <span class="badge rounded-pill" style="background-color:#C4B5FD;">&nbsp;&nbsp;</span> Sakit
  </li>
</ul>

      </div>
    </div>
  </div>
</div>



                {{-- Persentase Pengisian Logbook --}}
              <div class="col-md-6 mb-4">
  <div class="card h-100 shadow-sm border-0">
    <div class="card-body text-center mt-3">
      <h5 class="card-title mb-2 fw-semibold">Persentase Pengisian Logbook</h5>
      <h6 class="text-primary mb-2">
        Bulan {{ \Carbon\Carbon::now()->translatedFormat('F') }}
      </h6>

      {{-- Grafik donut dengan teks di tengah --}}
      <div class="position-relative d-inline-block" style="width:240px; height:240px; margin-top:20px;">
        <canvas id="logbookChart" width="240" height="240"></canvas>

        {{-- 🖤 Teks tengah warna hitam --}}
        <div id="chartCenterText"
          class="position-absolute top-50 start-50 translate-middle text-center"
          style="color:#000;">
          <h6 id="centerLabel" class="mb-1 fw-semibold" style="color:#000;">Terisi</h6>
          <span id="centerValue" class="fw-bold fs-4" style="color:#000;">{{ $persenIsi }}%</span>
        </div>
      </div>

      {{-- Tombol interaktif --}}
      <div class="d-flex justify-content-center mb-4 gap-3 mt-3">
        <button id="btnTerisi" class="btn btn-sm rounded-pill px-3 py-1 active"
          style="background-color:#A78BFA; color:white; border:none; opacity:1;">
          Terisi
        </button>
        <button id="btnTidakIsi" class="btn btn-sm rounded-pill px-3 py-1"
          style="background-color:#60A5FA; color:white; border:none; opacity:0.7;">
          Tidak Isi
        </button>
      </div>

      {{-- Info detail --}}
      <ul class="list-unstyled mt-3 mb-2 small fw-semibold text-secondary">
        <li>
          <span class="badge rounded-pill me-2" style="background-color:#A78BFA;">&nbsp;</span>
          {{ $totalIsi }} Logbook terisi
        </li>
        <li>
          <span class="badge rounded-pill me-2" style="background-color:#60A5FA;">&nbsp;</span>
          {{ $totalTidakIsi }} Logbook tidak terisi
        </li>
      </ul>
    </div>
  </div>
</div>

            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-xxl-4">

            {{-- Kotak Absen Presensi --}}
            <div class="card h-50">
                <div class="card-body text-center py-4">
                    <h5 class="card-title mb-2">Absensi Kehadiran - WFO/WFH</h5>
                    <p class="mb-4" style="margin-top: 30px;">Apakah Anda sudah melakukan <br> presensi hari ini?</p>

                    {{-- Tombol Masuk --}}
                    <button type="button"
                        class="btn btn-{{ !$presensi || !$presensi->jam_masuk ? 'primary' : 'success' }} w-100 mb-2"
                        data-bs-toggle="modal" data-bs-target="#modalPresensiMasuk"
                        {{ $presensi && $presensi->jam_masuk && !$presensi->jam_pulang ? 'disabled' : '' }}>
                        <i class="bx bx-bell"></i>
                        @if (!$presensi || !$presensi->jam_masuk)
                            Masuk
                        @else
                            Masuk {{ date('H:i:s', strtotime($presensi->jam_masuk)) }}
                        @endif
                    </button>
                    <p class="text-start" style="color: black">
                        Jadwal hadir sebelum jam 09:00.
                    </p>

                    <!-- Modal Presensi Masuk -->
                    <div class="modal fade" id="modalPresensiMasuk" tabindex="-1">
                        <div class="modal-dialog">
                            {{-- ✅ Route diperbaiki ke user.presensi.masuk --}}
                            <form method="POST" action="{{ route('user.presensi.masuk') }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Presensi Masuk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label for="kegiatan" class="form-label">Pilih Kegiatan</label>
                                        <select name="kegiatan" id="kegiatan" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="WFO">WFO</option>
                                            <option value="WFH">WFH</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Rekam Jam Masuk</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Tombol Pulang --}}

                    @php
                        $now = \Carbon\Carbon::now()->format('H:i');
                        $bisaPulang = $now >= '16:00';
                    @endphp

                    <button class="btn btn-success w-100" data-bs-toggle="modal" style="margin-top: 10px;"
                        data-bs-target="#modalLogbook"
                        {{ !$presensi || !$presensi->jam_masuk || $presensi->jam_pulang ? 'disabled' : '' }}>
                        <i class="bx bx-log-out"></i>
                        Pulang
                        {{ $presensi && $presensi->jam_pulang ? date('H:i:s', strtotime($presensi->jam_pulang)) : '' }}
                    </button>
                    <p class="text-start" style="color: black">
                        Jadwal presensi pulang mulai jam 16:00 s/d jam 23:00
                    </p>

                    {{-- Info waktu --}}
                    @if ($presensi)
                        <hr class="my-4">
                        <div class="d-flex justify-content-between text-muted">
                            <div>Masuk : {{ $presensi->jam_masuk ?? '-' }}</div>
                            <div>Pulang : {{ $presensi->jam_pulang ?? '-' }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Modal Logbook Pulang -->
            <div class="modal fade" id="modalLogbook" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    {{-- ✅ Route diperbaiki ke user.presensi.pulang --}}
                    <form id="logbookForm" method="POST" action="{{ route('user.presensi.pulang') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Isi Logbook Hari Ini</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                @for ($i = 1; $i <= 10; $i++)
                                    <div class="row mb-2">
                                        <div class="col-md-9">
                                            <input type="text" name="catatan_pekerjaan[]" class="form-control"
                                                placeholder="Kegiatan {{ $i }}">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="status[]" class="form-control">
                                                <option value="Selesai">Selesai</option>
                                                <option value="Belum">Belum</option>
                                            </select>
                                        </div>
                                    </div>
                                @endfor
                                <input type="hidden" name="jam_pulang" id="jamPulang">
                            </div>

                            <div class="modal-footer">
                                <button id="btnSimpanLogbook" type="submit" class="btn btn-success">
                                    Simpan & Pulang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            {{-- Jumlah Pegawai Universitas Riau --}}
            <div class="mb-4 mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Header --}}
                        <div class="d-flex align-items-start justify-content-between mb-1">
                            <h5 class="card-title mb-0 text-primary fw-semibold">
                                Jumlah Pegawai Universitas Riau
                            </h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOptMain" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOptMain">
                                    <a class="dropdown-item" href="#">View More</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>
                        </div>

                        {{-- Chart --}}
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div id="pegawaiChart" style="min-height: 230px; width: 100%;"></div>
                        </div>

                        {{-- Legend --}}
                        <div class="mt-4 text-center">
                            <ul id="pegawaiLegend"
                                class="list-unstyled mb-0 d-flex justify-content-center flex-wrap small fw-semibold text-secondary gap-3">
                                <li class="legend-item active d-flex align-items-center" data-index="0" data-label="PNS"
                                    data-value="{{ $jumlahPNS ?? 0 }}">
                                    <span class="legend-dot me-2" style="background-color:#4B77BE;"></span>
                                    {{ number_format($jumlahPNS ?? 0) }} PNS
                                </li>
                                <li class="legend-item d-flex align-items-center" data-index="1" data-label="P3K"
                                    data-value="{{ $jumlahP3K ?? 0 }}">
                                    <span class="legend-dot me-2" style="background-color:#10B981;"></span>
                                    {{ number_format($jumlahP3K ?? 0) }} P3K
                                </li>
                                <li class="legend-item d-flex align-items-center" data-index="2" data-label="PHL"
                                    data-value="{{ $jumlahPHL ?? 0 }}">
                                    <span class="legend-dot me-2" style="background-color:#9CA3AF;"></span>
                                    {{ number_format($jumlahPHL ?? 0) }} PHL
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


        </div> {{-- END KOLOM KANAN --}}
    </div> {{-- END ROW --}}



    <style>
        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
            display: block;
        }
          /* Warna teks di tengah chart */
  #laporanCenter {
    color: #000 !important; /* pastikan semua teks di dalamnya hitam */
  }

  #laporanLabel,
  #laporanValue {
    color: #000 !important; /* ubah label dan nilai jadi hitam */
  }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
           // === CHART LOGBOOK ===
const ctx = document.getElementById('logbookChart');
const chart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Terisi', 'Tidak Isi'],
    datasets: [{
      data: [{{ $persenIsi }}, {{ $persenTidakIsi }}],
      backgroundColor: ['#A78BFA', '#60A5FA'], // ungu & biru lembut
      borderWidth: 2,
      borderColor: '#fff',
      cutout: '75%',
    }]
  },
  options: {
    plugins: {
      legend: { display: false },
      tooltip: {
        enabled: true,
        backgroundColor: '#1F2937',
        titleColor: '#fff',
        bodyColor: '#E5E7EB',
        displayColors: false,
        padding: 10,
        cornerRadius: 8,
        callbacks: {
          label: (context) => `${context.label}: ${context.formattedValue || 0}%`
        }
      }
    },
    responsive: false,
    animation: { animateRotate: true, animateScale: true }
  }
});

// === Teks tengah chart ===
const labelEl = document.getElementById('centerLabel');
const valueEl = document.getElementById('centerValue');
const btnTerisi = document.getElementById('btnTerisi');
const btnTidakIsi = document.getElementById('btnTidakIsi');

// Tombol Terisi
btnTerisi.addEventListener('click', () => {
  btnTerisi.style.opacity = '1';
  btnTidakIsi.style.opacity = '0.7';
  labelEl.textContent = 'Terisi';
  valueEl.textContent = '{{ $persenIsi }}%';
  // warna hitam selalu
  labelEl.style.color = '#000';
  valueEl.style.color = '#000';
});

// Tombol Tidak Isi
btnTidakIsi.addEventListener('click', () => {
  btnTidakIsi.style.opacity = '1';
  btnTerisi.style.opacity = '0.7';
  labelEl.textContent = 'Tidak Isi';
  valueEl.textContent = '{{ $persenTidakIsi }}%';
  // warna hitam selalu
  labelEl.style.color = '#000';
  valueEl.style.color = '#000';
});

            // === CHART PEGAWAI UNRI ===
            var jumlahPNS = {{ $jumlahPNS ?? 0 }};
            var jumlahP3K = {{ $jumlahP3K ?? 0 }};
            var jumlahPHL = {{ $jumlahPHL ?? 0 }};

            var labels = ['PNS', 'P3K', 'PHL'];
            var series = [jumlahPNS, jumlahP3K, jumlahPHL];
            var colors = ['#4B77BE', '#10B981', '#9CA3AF'];
            var activeIndex = 0;

            var pegawaiChart = new ApexCharts(document.querySelector("#pegawaiChart"), {
                series: series,
                chart: {
                    type: 'donut',
                    height: 230,
                    toolbar: {
                        show: false
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            var index = config.dataPointIndex;
                            activeIndex = index;
                            updateCenter(index);
                            updateLegend(index);
                            highlightSlice(index);
                        }
                    }
                },
                labels: labels,
                colors: colors,
                plotOptions: {
                    pie: {
                        expandOnClick: false,
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    color: '#6B7280',
                                    fontSize: '14px',
                                    offsetY: 25
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#111827',
                                    offsetY: -20,
                                    formatter: val => parseInt(val).toLocaleString()
                                },
                                total: {
                                    show: true,
                                    label: labels[0],
                                    fontSize: '15px',
                                    color: '#6B7280',
                                    formatter: () => series[0].toLocaleString()
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 4,
                    colors: ['#fff']
                },
                legend: {
                    show: false
                },
                tooltip: {
                    y: {
                        formatter: val => val.toLocaleString() + ' Pegawai'
                    }
                }
            });

            pegawaiChart.render();

            function updateCenter(index) {
                pegawaiChart.updateOptions({
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    total: {
                                        label: labels[index],
                                        formatter: () => series[index].toLocaleString()
                                    }
                                }
                            }
                        }
                    }
                });
            }

            function updateLegend(index) {
                document.querySelectorAll('#pegawaiLegend .legend-item').forEach((li, i) => {
                    li.classList.toggle('active', i === index);
                });
            }

            function highlightSlice(index) {
                pegawaiChart.toggleDataPointSelection(index);
            }

            document.querySelectorAll('#pegawaiLegend .legend-item').forEach((item, index) => {
                item.addEventListener('click', function() {
                    activeIndex = index;
                    updateCenter(index);
                    updateLegend(index);
                    highlightSlice(index);
                });
            });


           // === CHART PERSENTASE LAPORAN (PER BULAN) ===
const laporanCtx = document.getElementById('laporanChart');

const dataValues = [
  {{ $persenHadir ?? 0 }},
  {{ $persenDL ?? 0 }},
  {{ $persenCuti ?? 0 }},
  {{ $persenSakit ?? 0 }}
];

const total = dataValues.reduce((a, b) => a + b, 0);

// 🎨 Warna Sneat soft (merah & kuning diganti abu & ungu)
const softColors = ['#6EE7B7', '#93C5FD', '#D1D5DB', '#C4B5FD']; 
// Hijau, Biru, Abu, Ungu lembut

const chartData = total === 0 ? [1] : dataValues;
const chartColors = total === 0 ? ['#E5E7EB'] : softColors;

const laporanChart = new Chart(laporanCtx, {
  type: 'doughnut',
  data: {
    labels: total === 0 ? ['Tidak ada data'] : ['Hadir', 'Dinas Luar', 'Cuti', 'Sakit'],
    datasets: [{
      data: chartData,
      backgroundColor: chartColors,
      borderColor: '#fff',
      borderWidth: 2,
      hoverBorderWidth: 6,
      cutout: '72%'
    }]
  },
  options: {
    maintainAspectRatio: false,
    layout: { padding: 10 },
    plugins: {
      legend: { display: false },
      tooltip: {
        enabled: total !== 0,
        backgroundColor: '#1F2937',
        titleColor: '#fff',
        bodyColor: '#E5E7EB',
        displayColors: false,
        padding: 10,
        cornerRadius: 8,
        callbacks: {
          label: (context) => `${context.label}: ${context.formattedValue || 0}%`
        }
      }
    },
    animation: { animateRotate: true, animateScale: true },
    responsive: true
  }
});

            // === INTERAKSI DINAMIS ===
            const laporanItems = document.querySelectorAll('.laporan-item');
            const laporanLabel = document.getElementById('laporanLabel');
            const laporanValue = document.getElementById('laporanValue');

            laporanItems.forEach(item => {
                item.addEventListener('click', () => {
                    const type = item.dataset.type;
                    const value = item.dataset.value;

                    laporanLabel.textContent = type;
                    laporanValue.textContent = `${value}%`;

                    laporanValue.classList.remove('text-success', 'text-primary', 'text-warning',
                        'text-danger');
                    if (type === 'Hadir') laporanValue.classList.add('text-success');
                    else if (type === 'Dinas Luar') laporanValue.classList.add('text-primary');
                    else if (type === 'Cuti') laporanValue.classList.add('text-warning');
                    else if (type === 'Sakit') laporanValue.classList.add('text-danger');
                });
            });
        </script>
    @endpush


@endsection
