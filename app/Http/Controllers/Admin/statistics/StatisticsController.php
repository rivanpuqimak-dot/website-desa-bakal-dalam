<?php

namespace App\Http\Controllers\Admin\statistics;

use App\Http\Controllers\Controller;
use App\Models\VillageStatistic;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics = VillageStatistic::first();

        return view('admin.statistics.index', compact('statistics'));
    }

    public function store(Request $request)
    {
        // Normalisasi format desimal: ubah koma (,) menjadi titik (.)
        $fieldsToNormalize = ['luas_wilayah', 'luas_sawah', 'luas_perkebunan'];
        foreach ($fieldsToNormalize as $field) {
            $value = $request->input($field);
            if (is_string($value)) {
                $request->merge([
                    $field => str_replace(',', '.', str_replace(' ', '', $value)),
                ]);
            }
        }

        $request->validate($this->rules(), $this->messages());

        $statistics = VillageStatistic::first();

        if (! $statistics) {
            $statistics = new VillageStatistic();
        }

        $statistics->fill($request->all());
        $statistics->save();

        return back()->with('success', 'Statistik desa berhasil disimpan.');
    }

    protected function rules(): array
    {
        return [
            'jumlah_penduduk' => 'required|integer|min:0',
            'jumlah_kk' => 'required|integer|min:0',
            'jumlah_dusun' => 'required|integer|min:0',

'luas_wilayah' => 'required|numeric|min:0',
            'luas_sawah' => 'required|numeric|min:0',
            'luas_perkebunan' => 'required|numeric|min:0',
            'jumlah_umkm' => 'required|integer|min:0',
            'jumlah_masjid' => 'required|integer|min:0',
            'jumlah_sekolah' => 'required|integer|min:0',

            'jumlah_posyandu' => 'required|integer|min:0',
        ];
    }

    protected function messages(): array
    {
        return [
            'required' => 'Field ini wajib diisi.',
            'integer' => 'Field ini harus berupa angka.',
            'min' => 'Field ini tidak boleh bernilai negatif.',
        ];
    }
}
