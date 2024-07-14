<div class="d-flex justify-content-start align-items-center gap-2">
    @if ($jadwalasesmen->status == 'SUBMITTED' && $jadwalasesmen->penilaian->nama_pemohon != null)
        <button data-action="edit" data-url="{{ route('asesmen.jadwal-asesmen.edit', $jadwalasesmen->id) }}"
            data-modal-id="verifikasi-jadwal-asesmen-modal" data-title="kecamatan" data-target="#verifikasi-jadwal-asesmen-modal"
            class="btn btn-primary d-flex align-items-center text-end w-80">
            <i class="fas fa-check fs-4 me-2"></i>Verifikasi
        </button>
    @endif
    <a href="{{ route('asesmen.jadwal-asesmen.show', $jadwalasesmen->id) }}"class="btn btn-info">
        <i class="fas fa-eye fs-4"></i>
    </a>
</div>
