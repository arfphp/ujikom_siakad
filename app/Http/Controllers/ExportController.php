<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function krsPdf($nim, $semester)
{
    $mahasiswa = Mahasiswa::with([
        'golongan',
        'krs' => function($query) use ($semester) {
            $query->whereHas('matakuliah', function($q) use ($semester) {
                $q->where('semester', $semester);
            })->with(['matakuliah' => function($query) {
                $query->with(['pengampu.dosen', 'jadwal.ruang']);
            }]);
        }
    ])->where('NIM', $nim)->firstOrFail();

    // Filter KRS yang memiliki matakuliah valid
    $krs = $mahasiswa->krs->filter(function ($item) {
        return !is_null($item->matakuliah);
    });

    if($krs->isEmpty()) {
        abort(404, 'Tidak ada data KRS untuk semester ini');
    }

    $totalSKS = $krs->sum(fn($item) => $item->matakuliah->sks);

    $pdf = PDF::loadView('exports.krspdf', [
        'mahasiswa' => $mahasiswa,
        'krs' => $krs,
        'totalSKS' => $totalSKS,
        'semester' => $semester
    ]);

    return $pdf->download("krs-{$nim}-semester-{$semester}.pdf");
}
}
