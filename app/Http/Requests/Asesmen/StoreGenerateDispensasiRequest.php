<?php

namespace App\Http\Requests\Asesmen;

use App\Models\AsesmenJadwal;
use App\Models\Master\Periode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGenerateDispensasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nomor_surat' => [
                'required',
                function ($attribute, $value, $fail) {
                    $list_penilaian_asesmen = AsesmenJadwal::where([
                        "dispensasi_id" => $this->dispensasi->id,
                        "periode_id"=> Periode::getCurrent()->id,
                    ])
                        ->withCount([
                            "asesmen_penilaian",
                            "asesmen_penilaian as asesmen_penilaian_scored" => function ($query) {
                                $query->whereNotNull("status_rekomendasi");
                            }
                        ])->first(["asesmen_penilaian_count", "asesmen_penilaian_scored_count"]);

                    if (!$list_penilaian_asesmen->exists) {
                        $fail("Tidak ada asesor yang terdaftar pada dispensasi ini");
                    }
                    if ($list_penilaian_asesmen->asesmen_penilaian_count != $list_penilaian_asesmen->asesmen_penilaian_scored) {
                        $fail("Tidak dapat melakukan input nomor surat dispensasi karena belum dilakukan proses asesmen");
                    }
                },
            ],
            'file' => 'required|file|mimes:pdf|max:2048',
        ];
        return $rules;
    }

    public function messages(): array
    {
        return [
            'nomor_surat.required' => 'Nomor Surat harus diisi',
            'file.required' => 'File harus diisi',
            'file.file' => 'File harus berupa pdf',
        ];
    }
}
