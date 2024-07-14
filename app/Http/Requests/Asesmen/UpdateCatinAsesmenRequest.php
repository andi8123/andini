<?php

namespace App\Http\Requests\Asesmen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCatinAsesmenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lama_hubungan' => 'required|string|max:255',
            'nama_pemohon' => 'required|string|max:255',
            'alasan_menikah' => 'required|string|max:255',
            'gaya_berpacaran' => 'required|string|max:255',
            'pekerjaan_catin' => 'required|string|max:255',
            'penghasilan_catin' => 'required|string|max:255',
            'persetujuan_keluarga' => 'required|string|max:255',
            'pola_hubungan' => 'required|string|max:65535',
            'catatan' => 'required|string|max:65535',
            'status_rekomendasi' => 'required|in:DIREKOMENDASIKAN,TIDAK_DIREKOMENDASIKAN',
            'keterangan' => 'required|string|max:65535',
        ];
    }

    public function messages(): array
    {
        return [
            'lama_hubungan.string' => 'required|Lama hubungan harus berupa teks',
            'lama_hubungan.max' => 'required|Lama hubungan tidak boleh lebih dari 255 karakter',
            'alasan_menikah.string' => 'required|Alasan menikah harus berupa teks',
            'alasan_menikah.max' => 'required|Alasan menikah tidak boleh lebih dari 255 karakter',
            'gaya_berpacaran.string' => 'required|Gaya berpacaran harus berupa teks',
            'gaya_berpacaran.max' => 'required|Gaya berpacaran tidak boleh lebih dari 255 karakter',
            'pekerjaan_catin.string' => 'required|Pekerjaan catin harus berupa teks',
            'pekerjaan_catin.max' => 'required|Pekerjaan catin tidak boleh lebih dari 255 karakter',
            'penghasilan_catin.string' => 'required|Penghasilan catin harus berupa teks',
            'penghasilan_catin.max' => 'required|Penghasilan catin tidak boleh lebih dari 255 karakter',
            'persetujuan_keluarga.string' => 'required|Persetujuan keluarga harus berupa teks',
            'persetujuan_keluarga.max' => 'required|Persetujuan keluarga tidak boleh lebih dari 255 karakter',
            'pola_hubungan.string' => 'required|Pola hubungan harus berupa teks',
            'pola_hubungan.max' => 'required|Pola hubungan tidak boleh lebih dari 65535 karakter',
            'penilaian.string' => 'required|Penilaian harus berupa teks',
            'penilaian.max' => 'required|Penilaian tidak boleh lebih dari 65535 karakter',
            'catatan.string' => 'required|Catatan harus berupa teks',
            'catatan.max' => 'required|Catatan tidak boleh lebih dari 65535 karakter',
            'status_rekomendasi.in' => 'required|Status rekomendasi harus salah satu dari: DIREKOMENDASIKAN, TIDAK_DIREKOMENDASIKAN',
            'keterangan.string' => 'required|Keterangan harus berupa teks',
            'keterangan.max' => 'required|Keterangan tidak boleh lebih dari 65535 karakter',
        ];
    }
}
