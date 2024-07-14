<?php

namespace App\DataTables\Catin;

use App\Models\Dispensasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VerifikasiCatinDataTable extends DataTable
{
    public function __construct(protected $status = null)
    {
        $this->status = $status;
    }
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('aksi', function (Dispensasi $val) {
                return view('pages.admin.verifikasi-catin.partials.action', ['verifikasi_catin' => $val]);
            })
            ->editColumn('catin_pria.nama_lengkap', function (Dispensasi $data) {
                return view('components.datatables.catin.catin', [
                    'data' => $data->catin_pria
                ]);
            })
            ->editColumn('catin_wanita.nama_lengkap', function (Dispensasi $data) {
                return view('components.datatables.catin.catin', [
                    'data' => $data->catin_wanita
                ]);
            })
            ->editColumn('status_persetujuan_dispensasi', function (Dispensasi $val) {
                $color = match ($val->status_persetujuan) {
                    "SUBMITTED" => "warning",
                    "APPROVED" => "success",
                    "REJECTED" => "danger",
                    "RECEIVED" => "info",
                    "PROPOSED" => "primary",
                };
                $message = match ($val->status_persetujuan) {
                    "SUBMITTED" => "Menunggu Persetujuan",
                    "APPROVED" => "Disetujui",
                    "REJECTED" => "Tidak Disetujui",
                    "RECEIVED" => "Diterima",
                    "PROPOSED" => "Diproses",
                };
                return '<span class="badge bg-' . $color . '">' . $message . '</span>';
            })
            ->editColumn('nomor_surat', function (Dispensasi $val) {
                if ($val->nomor_surat == null) {
                    return '<span class="badge bg-info">Belum ada</span>';
                } else {
                    return $val->nomor_surat;
                }
            })
            ->editColumn('tanggal_pengajuan', function (Dispensasi $val) {
                return formatDateIndonesia($val->tanggal_pengajuan);
            })
            ->rawColumns(['aksi', 'status_persetujuan_dispensasi', 'nomor_surat', 'tanggal_pengajuan'])
            ->setRowId('id');
    }

    public function query(Dispensasi $model): QueryBuilder
    {
        $params = request()->only(['status']);
        $query = $model->newQuery()->with('register', 'catin_pria', 'catin_wanita')->when(isset($params['status']), function ($query) use ($params) {
            $query->where('status_persetujuan', $params['status']);
        })->select('dispensasi.*', 'dispensasi.status_persetujuan as status_persetujuan_dispensasi')
            ->orderBy('dispensasi.created_at', 'desc');
        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('verifikasi-catin-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('register.nama')->title('Nama Pendaftar')->data('register.nama')->orderable(false),
            Column::make('catin_pria.nama_lengkap')->title('Catin Pria')->data('catin_pria.nama_lengkap')->orderable(false),
            Column::make('catin_wanita.nama_lengkap')->title('Catin Wanita')->data('catin_wanita.nama_lengkap')->orderable(false),
            Column::make('nomor_surat')->title('Nomor Registrasi')->orderable(false),
            Column::make('tanggal_pengajuan')->title('Tgl. Pengajuan'),
            Column::make('status_persetujuan_dispensasi')->title('Status')->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'catin_' . date('YmdHis');
    }
}
