@extends('user.base')

@section('content')
    <div class="text-center">
        <h1>Selamat datang, {{ Auth::user()->name }}</h1>
        <p>Presensi hari ini:</p>

        @if($presensi && $presensi->jam_masuk)
            <p>Jam Masuk: {{ $presensi->jam_masuk }}</p>
        @else
            <p>Belum presensi masuk hari ini.</p>
        @endif
    </div>
@endsection
@push('scripts')
<script>
  $('#logbookForm').on('submit', function(e) {
    e.preventDefault();

    let form = $(this);
    let btn = $('#btnSimpanLogbook');

    // Ambil waktu sekarang dalam format HH:mm:ss
    let now = new Date();
    let jamPulang = now.toTimeString().split(' ')[0];

    // Isi hidden input
    $('#jamPulang').val(jamPulang);

    // Disable button
    btn.prop('disabled', true).text('Menyimpan...');

    // Kirim data via AJAX
    $.ajax({
      url: "{{ route('logbook.store') }}",
      method: 'POST',
      data: form.serialize(),
      success: function(res) {
        $('#modalLogbook').modal('hide');
        form[0].reset();
        btn.prop('disabled', false).text('Simpan & Pulang');
        alert('Logbook dan jam pulang berhasil disimpan.');

        // Reload halaman agar info presensi/logbook update
        location.reload();
      },
      error: function(err) {
        btn.prop('disabled', false).text('Simpan & Pulang');
        alert('Terjadi kesalahan saat menyimpan.');
      }
    });
  });
</script>
@endpush


