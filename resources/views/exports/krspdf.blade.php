<!DOCTYPE html>
<html>
<head>
    <title>KRS {{ $mahasiswa->NIM }}</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KARTU RENCANA STUDI</h2>
        <p>NIM: {{ $mahasiswa->NIM }}</p>
        <p>Nama: {{ $mahasiswa->Nama }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
            </tr>
        </thead>
        <tbody>
            @foreach($krs as $item)
            <tr>
                <td>{{ $item->matakuliah->Kode_mk }}</td>
                <td>{{ $item->matakuliah->Nama_mk }}</td>
                <td>{{ $item->matakuliah->sks }}</td>
                <td>{{ $item->matakuliah->semester }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>