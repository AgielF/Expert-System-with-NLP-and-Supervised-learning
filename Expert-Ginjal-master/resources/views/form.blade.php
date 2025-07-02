<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kidney Health Screening</title>
    @vite('resources/css/app.css')
</head>

<style>
  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
</style>

<body class="bg-gradient-to-br from-slate-100 to-blue-100 min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-5xl bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-500 text-white text-center py-6">
            <h1 class="text-2xl font-bold uppercase tracking-wide">Kidney Health Screening</h1>
        </div>
        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach                    <!--ini buat kondisi kalau si isian harus ada -->
            </ul>
        </div>
        @endif
        <!-- Form -->
        <form method="POST" action="{{ route('diagnose.proses') }}" class="p-6 md:p-10"> <!-- Route Post ini untuk dikirimkan ke halaman 'hasil' dengan variabel diagnose.proses di web.phpnya -->
            @csrf

            {{-- Show general validation message --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    <strong>Oops!</strong> Ada kesalahan input. Silakan periksa formulir di bawah.
                </div>
            @endif

            {{-- ⚕️ Section 1: Pemeriksaan Fisik --}}
            <h2 class="text-xl font-semibold border-b pb-1">Pemeriksaan Fisik</h2>
            
            {{-- Usia --}}
            <div class="mb-4">
                <label for="usia" class="block">Usia (tahun)</label>
                <input type="number" name="usia" id="usia"
                    value="{{ old('usia') }}"
                    class="w-full border p-2 rounded appearance-none"
                    placeholder="Contoh: 45"
                    min="0" max="120"
                    required>
                <small class="text-gray-500">Masukkan usia antara 0–120 tahun</small>
                @error('usia')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Suhu Tubuh --}}
            <div class="mb-4">
                <label for="suhu_tubuh" class="block">Suhu Tubuh (°C)</label>
                <input type="number" step="0.1" name="suhu_tubuh" id="suhu_tubuh"
                    value="{{ old('suhu_tubuh') }}"
                    class="w-full border p-2 rounded appearance-none"
                    placeholder="Contoh: 36.5"
                    min="30" max="45"
                    required>
                <small class="text-gray-500">Normal: 36–37°C | Batas aman: 30–45°C</small>
                @error('suhu_tubuh')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tekanan Darah --}}
            <div class="mb-4">
                <label for="tekanan_darah" class="block">Tekanan Darah (mmHg)</label>
                <input type="number" name="tekanan_darah" id="tekanan_darah"
                    value="{{ old('tekanan_darah') }}"
                    class="w-full border p-2 rounded appearance-none"
                    min="70" max="200"
                    required>
                <small class="text-gray-500">Normal: 90–120 mmHg | Batas aman: 70–200 mmHg</small>
                @error('tekanan_darah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Asam Urat --}}
            <div class="mb-4">
                <label for="asam_urat" class="block">Asam Urat (mg/dL)</label>
                <input type="number" step="0.1" name="asam_urat" id="asam_urat"
                    value="{{ old('asam_urat') }}"
                    class="w-full border p-2 rounded appearance-none"
                    min="0" max="20"
                    required>
                <small class="text-gray-500">Normal: 3.4–7.0 (pria), 2.4–6.0 (wanita)</small>
                @error('asam_urat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Section 2: Pemeriksaan Urine --}}
            <h2 class="text-xl font-semibold border-b pb-1 pt-6">Pemeriksaan Urine</h2>

            {{-- Kadar Urine --}}
            <div class="mb-4">
                <label for="kadar_urine" class="block">Kadar Urine (mg/L)</label>
                <input type="number" name="kadar_urine" id="kadar_urine"
                    value="{{ old('kadar_urine') }}"
                    class="w-full border p-2 rounded appearance-none"
                    min="0" max="1000"
                    required>
                <small class="text-gray-500">Normal: < 150 mg/24 jam</small>
                @error('kadar_urine')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Warna Urine --}}
            <div class="mb-4">
                <label for="warna_urine" class="block">Warna Urine</label>
                <select name="warna_urine" id="warna_urine" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Warna --</option>
                    <option value="jernih" {{ old('warna_urine') == 'jernih' ? 'selected' : '' }}>Jernih</option>
                    <option value="kuning" {{ old('warna_urine') == 'kuning' ? 'selected' : '' }}>Kuning</option>
                    <option value="keruh" {{ old('warna_urine') == 'keruh' ? 'selected' : '' }}>Keruh</option>
                </select>
                <small class="text-gray-500">Urine keruh bisa menjadi tanda infeksi</small>
                @error('warna_urine')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konsumsi Air Putih --}}
            <div class="mb-4">
                <label for="konsumsi_air_putih" class="block">Konsumsi Air Putih (gelas/hari)</label>
                <input type="number" name="konsumsi_air_putih" id="konsumsi_air_putih"
                    value="{{ old('konsumsi_air_putih') }}"
                    class="w-full border p-2 rounded appearance-none"
                    min="0" max="20"
                    required>
                <small class="text-gray-500">Disarankan minimal 8 gelas per hari</small>
                @error('konsumsi_air_putih')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Section 3: Gejala Fisik --}}
            <h2 class="text-xl font-semibold border-b pb-1 pt-6">Gejala Fisik</h2>

            @foreach ([
                'nyeri_pinggang' => 'Nyeri Pinggang',
                'sering_berkemih' => 'Sering Berkemih',
                'mudah_lelah' => 'Mudah Lelah',
                'mual_muntah' => 'Mual atau Muntah'
            ] as $name => $label)
                <div class="mb-4">
                    <label class="block font-medium">{{ $label }}</label>
                    <div class="flex gap-4 mt-1">
                        <label>
                            <input type="radio" name="{{ $name }}" value="Ya"
                                {{ old($name) == 'Ya' ? 'checked' : '' }} required> Ya
                        </label>
                        <label>
                            <input type="radio" name="{{ $name }}" value="Tidak"
                                {{ old($name) == 'Tidak' ? 'checked' : '' }}> Tidak
                        </label>
                    </div>
                    @error($name)
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            {{-- 🧬 Section 4: Riwayat Kesehatan --}}
            <h2 class="text-xl font-semibold border-b pb-1 pt-6">Riwayat Kesehatan</h2>

            @foreach ([
                'riwayat_ginjal' => 'Riwayat Penyakit Ginjal',
                'riwayat_hipertensi' => 'Riwayat Hipertensi',
                'riwayat_diabetes' => 'Riwayat Diabetes'
            ] as $name => $label)
                <div class="mb-4">
                    <label class="block font-medium">{{ $label }}</label>
                    <div class="flex gap-4 mt-1">
                        <label>
                            <input type="radio" name="{{ $name }}" value="Ya"
                                {{ old($name) == 'Ya' ? 'checked' : '' }} required> Ya
                        </label>
                        <label>
                            <input type="radio" name="{{ $name }}" value="Tidak"
                                {{ old($name) == 'Tidak' ? 'checked' : '' }}> Tidak
                        </label>
                    </div>
                    @error($name)
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach


            {{-- Submit Button --}}
            <div class="pt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Submit Diagnosa
                </button>
            </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/formRules.js') }}"></script>
</body>
</html>
