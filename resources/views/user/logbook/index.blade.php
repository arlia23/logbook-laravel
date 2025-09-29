@extends('template.index')

@section('title', 'Logbook')

@section('main')
<div class="card">
  <div class="card-header d-flex justify-content-between">
      <h5>Log Book</h5>
      <div>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPresensi">
              Presensi Masuk
          </button>
      </div>
  </div>

  <div class="table-responsive text-nowrap">
      <table class="table table-hover">
          <thead>
              <tr>
                  <th>Tanggal</th>
                  <th>Kegiatan</th>
                  <th>Catatan Pekerjaan</th>
                  <th>Jam Masuk</th>
                  <th>Jam Pulang</th>
              </tr>
          </thead>
          <tbody>
              @foreach($logbooks as $log)
              @php
                  $catatan = json_decode($log->catatan_pekerjaan, true);
              @endphp
              <tr>
                  <td>{{ $log->tanggal }}</td>
                  <td><span class="badge bg-label-primary">{{ $log->kegiatan }}</span></td>
                  <td>
                      @if($catatan && count($catatan) > 0)
                          <table class="table table-sm mb-0">
                              <thead>
                                  <tr>
                                      <th>Catatan</th>
                                      <th>Status</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($catatan as $c)
                                      <tr>
                                          <td>{{ $c['kegiatan'] }}</td>
                                          <td>
                                              <span class="badge {{ $c['status'] == 'Selesai' ? 'bg-success' : 'bg-warning' }}">
                                                  {{ $c['status'] }}
                                              </span>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      @else
                          -
                      @endif
                  </td>
                  <td>{{ $log->jam_masuk }}</td>
                  <td>{{ $log->jam_pulang ?? '-' }}</td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>

@include('user.presensi.modal')
@endsection
