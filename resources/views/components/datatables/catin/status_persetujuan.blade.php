@php
    $color = 'secondary';
    $text = '';
    if (isset($data)) {
        if ($data == 'SUBMITTED') {
            $color = 'light text-dark';
            $text = 'Belum Diajukan';
        } elseif ($data == 'PROPOSED') {
            $color = 'warning';
            $text = 'Menunggu Persetujuan';
        } elseif ($data == 'APPROVED') {
            $color = 'primary';
            $text = 'Disetujui';
        } elseif ($data == 'RECEIVED') {
            $color = 'success';
            $text = 'Diterima';
        } elseif ($data == 'REJECTED') {
            $color = 'danger';
            $text = 'Ditolak';
        }
    }
@endphp

<span class="badge bg-{{ $color }}">{{ $text }}</span>
