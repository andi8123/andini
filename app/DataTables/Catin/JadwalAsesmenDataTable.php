<?php

namespace App\DataTables\Catin;

use App\Helpers\Formatter;
use App\Models\Dispensasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JadwalAsesmenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('aksi', function (Dispensasi $val) {
                if ($val?->jadwalAsesmen) {
                    return view('pages.catin.jadwal-asesmen.partials.action', ['dispensasi' => $val]);
                } else {
                    return '<span class="badge bg-light text-dark">Belum Dijadwalkan</span>';
                }
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
            ->editColumn('jadwalAsesmen.tanggal_asesmen', function (Dispensasi $data) {
                if ($data->jadwalAsesmen?->tanggal_asesmen) {
                    return Formatter::datetime($data->jadwalAsesmen?->tanggal_asesmen);
                } else {
                    return '<span class="badge bg-light text-dark">Belum Dijadwalkan</span>';
                }
            })
            ->editColumn('jadwalAsesmen.penilaian.status_rekomendasi', function (Dispensasi $data) {
                if ($data?->jadwalAsesmen) {

                    if ($data->jadwalAsesmen->penilaian->status_rekomendasi == 'DIREKOMENDASIKAN') {
                        return '<span class="badge bg-success">Direkomendasikan</span>';
                    } elseif ($data->jadwalAsesmen->penilaian->status_rekomendasi == 'TIDAK_DIREKOMENDASIKAN') {
                        return '<span class="badge bg-danger">Tidak Direkomendasi</span>';
                    } else {
                        return '<span class="badge bg-info">Menunggu Asesmen</span>';
                    }
                } else {
                    return '<span class="badge bg-light text-dark">Belum Dinilai</span>';
                }
            })

            ->rawColumns(['aksi', 'jadwalAsesmen.penilaian.status_rekomendasi', 'jadwalAsesmen.tanggal_asesmen'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Dispensasi $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('catin_pria')
            ->with('catin_wanita')
            ->with('jadwalAsesmen')
            ->with('jadwalAsesmen.penilaian')
            ->where('register_id', auth()->user()->register?->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jadwal-asesmen-table')
            ->columns($this->getColumns())
            ->minifiedAjax(script: "
                        data._token = '" . csrf_token() . "';
                        data._p = 'POST';
                    ")
            ->addTableClass('table align-middle table-row-dashed gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold text-uppercase gs-0')
            ->select(false)
            ->orderBy(2)
            ->drawCallbackWithLivewire(file_get_contents(public_path('/assets/js/dataTables/drawCallback.js')))
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                ->title('No.')
                ->width(20)
                ->orderable(false),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('catin_pria.nama_lengkap')
                ->title('Calon Pengantin Pria')
                ->orderable(false),
            Column::make('catin_wanita.nama_lengkap')
                ->title('Calon Pengantin Wanita')
                ->orderable(false),
            Column::make('jadwalAsesmen.tanggal_asesmen')
                ->addClass('w-fit-td')
                ->title('Tanggal Asesmen')
                ->orderable(false),
            Column::make('jadwalAsesmen.penilaian.status_rekomendasi')
                ->addClass('w-fit-td')
                ->title('Status Rekomendasi')
                ->orderable(false)
                ->searchable(false),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'JadwalAsesmen_' . date('YmdHis');
    }
}
