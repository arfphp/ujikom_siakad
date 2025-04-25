<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function krsPdf($nim)
    {
        $mahasiswa = Mahasiswa::with(['krs.matakuliah'])
            ->where('NIM', $nim)
            ->firstOrFail();
            
        $pdf = PDF::loadView('exports.krspdf', [
            'mahasiswa' => $mahasiswa,
            'krs' => $mahasiswa->krs
        ]);
        
        return $pdf->download('krs-'.$nim.'.pdf');
    }
}
