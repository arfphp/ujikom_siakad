<!DOCTYPE html>
<html>
<head>
    <title>KRS {{ $mahasiswa->NIM }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KARTU RENCANA STUDI</h2>
        <p>NIM: {{ $mahasiswa->NIM }}</p>
        <p>Nama: {{ $mahasiswa->Nama }}</p>
        <p>Semester: {{ $semester }}</p>
        <p>Golongan: {{ $mahasiswa->golongan->nama_Gol }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Dosen Pengampu</th>
                <th>Jadwal & Ruang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($krs as $item)
                @if($item->matakuliah)
                <tr>
                    <td>{{ $item->matakuliah->Kode_mk }}</td>
                    <td>{{ $item->matakuliah->Nama_mk }}</td>
                    <td>{{ $item->matakuliah->sks }}</td>
                    <td>{{ $item->matakuliah->semester }}</td>
                    <td>
                        @foreach($item->matakuliah->pengampu as $pengampu)
                            {{ $pengampu->dosen->Nama }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($item->matakuliah->jadwal as $jadwal)
                            {{ $jadwal->hari }} ({{ $jadwal->ruang->nama_ruang }})@if(!$loop->last)<br>@endif
                        @endforeach
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="total">Total SKS</td>
                <td class="total">{{ $totalSKS }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
