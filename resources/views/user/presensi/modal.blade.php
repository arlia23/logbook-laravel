<div class="modal fade" id="modalLogbook" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('logbook.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Isi Logbook & Pulang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Catatan Pekerjaan</label>
            <textarea name="catatan_pekerjaan" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="Belum">Belum</option>
              <option value="Selesai">Selesai</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan & Pulang</button>
        </div>
      </div>
    </form>
  </div>
</div>
