<!-- resources/views/hasil.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-gray-100 to-blue-100 min-h-screen flex items-center justify-center px-4 py-10 font-sans">

    <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg p-8 md:p-12 space-y-8">
        <!-- Judul -->
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-600">Hasil Diagnosa Anda</h1>
            <p class="mt-2 text-gray-600 text-sm md:text-base">Berikut hasil analisa berdasarkan data yang Anda masukkan.</p>
        </div>

        <!-- Hasil Diagnosa -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-md">
            <p class="text-lg text-gray-800 mb-1 font-semibold">{{ $hasil }}</p> <!-- $hasil dari DiagnoseController.php. liat aja di app/http/controller. nah disitu ada variable buat nampung hasil -->
            <p class="text-sm text-gray-700">Skor diagnosa Anda: <span class="font-bold text-blue-600">{{ $skor }}</span></p>
        </div>

        <!-- Data yang Dimasukkan -->
        <div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Data yang Anda Masukkan:</h2>
            <ul class="list-disc list-inside text-gray-700 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm md:text-base">
                @foreach ($data as $key => $value)
                    <li><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Edukasi Penyakit Ginjal -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-5 rounded-md">
            <h3 class="text-lg font-semibold text-yellow-700 mb-2">Tentang Penyakit Ginjal</h3>
            <p class="text-sm text-gray-700 leading-relaxed">
                Penyakit ginjal terjadi ketika ginjal tidak dapat menyaring limbah dan cairan secara optimal. Gejala umum meliputi pembengkakan, kelelahan, dan perubahan warna urine.
                Faktor risiko utama termasuk tekanan darah tinggi, diabetes, dan riwayat keluarga. 
                <br><br>
                Menjaga pola makan sehat, konsumsi air putih yang cukup, dan pemeriksaan kesehatan secara berkala dapat membantu mencegah kerusakan ginjal.
            </p>
        </div>

        <!-- Tombol -->
        <div class="text-center">
            <a href="{{ route('hasil.export') }}"
                class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow transition">
                Download PDF
            </a>
            <a href="{{ route('form') }}"
               class="inline-block px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow transition">
                Kembali ke Formulir
            </a>
        </div>
    </div>

</body>
</html>

