
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hasil Diagnosa PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.6; font-size: 12px; }
        h1, h2 { color: #2c3e50; }
        ul { margin: 0; padding: 0; list-style-type: none; }
    </style>
</head>
<body>

    <h1>Hasil Diagnosa Anda</h1>
    <p><strong>{{ $hasil }}</strong></p>
    <p>Skor: <strong>{{ $skor }}</strong></p>

    <h2>Data yang Dimasukkan:</h2>
    <ul>
        @foreach ($data as $key => $value)
            <li><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>

    <h2>Tentang Penyakit Ginjal</h2>
    <p>
        Penyakit ginjal adalah kondisi ketika ginjal tidak mampu menyaring zat sisa dengan baik dari darah. <!-- Ini masi belum sesuai dengan penyakitnya jadi masih harus di ubah -->
        Pencegahan bisa dilakukan dengan menjaga pola makan, cukup minum air putih, dan pemeriksaan rutin.
    </p>

</body>
</html>
