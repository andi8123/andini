@php
    $canSubmit = true;
    if (isset($data)) {
        if (!$data->catin_pria?->isBerkasLengkap()) {
            $canSubmit = false;
        }
        if (!$data->catin_wanita?->isBerkasLengkap()) {
            $canSubmit = false;
        }
        if ($data->status_persetujuan != 'SUBMITTED') {
            $canSubmit = false;
        }
    } else {
        $canSubmit = false;
    }
@endphp

@can($globalModule['update'])
    <a href="{{ route('berkas-persyaratan.edit', $data->id) }}" class="btn btn-warning me-1">
        <i class="fas fa-pen fs-3 me-2"></i> Lengkapi
    </a>
    <button class="btn btn-primary {{ $canSubmit ? '' : 'disabled' }}" {{ $canSubmit ? '' : 'disabled' }}
        data-action="submit-verifikasi"
        data-url="{{ route('berkas-persyaratan.submit', ['dispensasi' => $data->id])}}"
        data-table-id="berkas-catin-table">
        <i class="fas fa-paper-plane fs-3 me-2"></i> Kirim
    </button>
@endcan

