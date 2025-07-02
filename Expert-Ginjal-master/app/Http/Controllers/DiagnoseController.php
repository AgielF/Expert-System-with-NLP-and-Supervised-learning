<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Wamania\Snowball\StemmerFactory;

//lupa import beberapa hal ini
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DiagnoseController extends Controller
{
    public function proses(Request $request)
    {
        $data = $request->validate([
            'usia' => 'required|integer|min:0|max:120',
            'suhu_tubuh' => 'required|numeric|between:30,45',
            'tekanan_darah' => 'required|numeric|min:70|max:200',
            'asam_urat' => 'required|numeric|min:0|max:20',
            'kadar_urine' => 'required|numeric|min:0|max:1000',
            'warna_urine' => 'required|in:jernih,kuning,keruh',
            'konsumsi_air_putih' => 'required|integer|min:0|max:20',
          
        ]);

        // Step 1: Fuzzy Membership Functions (example: suhu tubuh)
        $usia_score = $this->fuzzyUsia($data['usia']);
        $suhu_score = $this->fuzzySuhu($data['suhu_tubuh']);
        $tekanan_score = $this->fuzzyTekanan($data['tekanan_darah']);
        $asam_score = $this->fuzzyAsamUrat($data['asam_urat']);
        $urine_score = $this->fuzzyUrine($data['kadar_urine']);
        $air_score = $this->fuzzyAirPutih($data['konsumsi_air_putih']);

        // Convert Ya/Tidak to numeric
        $gejala = collect([
            'nyeri_pinggang' => $data['nyeri_pinggang'] === 'Ya' ? 1 : 0,
            'sering_berkemih' => $data['sering_berkemih'] === 'Ya' ? 1 : 0,
            'mudah_lelah' => $data['mudah_lelah'] === 'Ya' ? 1 : 0,
            'mual_muntah' => $data['mual_muntah'] === 'Ya' ? 1 : 0,
            'riwayat_ginjal' => $data['riwayat_ginjal'] === 'Ya' ? 1 : 0,
            'riwayat_hipertensi' => $data['riwayat_hipertensi'] === 'Ya' ? 1 : 0,
            'riwayat_diabetes' => $data['riwayat_diabetes'] === 'Ya' ? 1 : 0,
        ])->sum() / 7; // Normalize gejala score between 0–1


        // Step 2: Combine scores with simple rule weighting (defuzzification )
        $risk_score = (
            $usia_score * 0.1 +
            $suhu_score * 0.1 +
            $tekanan_score * 0.1 +
            $asam_score * 0.15 +
            $urine_score * 0.15 +
            $air_score * 0.1 +
            $gejala * 0.3
        );

        // Step 3: Interpret result
        if ($risk_score >= 0.7) {
            $hasil = "Kemungkinan gangguan ginjal. Disarankan konsultasi ke dokter.";
        } elseif ($risk_score >= 0.4) {
            $hasil = "Perlu waspada. Perhatikan gaya hidup dan konsultasi jika perlu.";
        } else {
            $hasil = "Tidak terindikasi gangguan ginjal berdasarkan data yang diberikan.";
        }
        $user = auth()->user(); // jika user login

$diagnosaData = [
    'user_id' => $user->id ?? null,
    'usia' => $data['usia'],
    'suhu_tubuh' => $data['suhu_tubuh'],
    'tekanan_darah' => $data['tekanan_darah'],
    'asam_urat' => $data['asam_urat'],
    'kadar_urine' => $data['kadar_urine'],
    'warna_urine' => $data['warna_urine'],
    'konsumsi_air_putih' => $data['konsumsi_air_putih'],
    'nyeri_pinggang' => $data['nyeri_pinggang'],
    'sering_berkemih' => $data['sering_berkemih'],
    'mudah_lelah' => $data['mudah_lelah'],
    'mual_muntah' => $data['mual_muntah'],
    'riwayat_ginjal' => $data['riwayat_ginjal'],
    'riwayat_hipertensi' => $data['riwayat_hipertensi'],
    'riwayat_diabetes' => $data['riwayat_diabetes'],
    'hasil' => $hasil,
    'skor' => round($risk_score, 2),
];

    \App\Models\Diagnosa::create($diagnosaData);
        session([
            'hasil' => $hasil,
            'data' => $data,
            'skor' => round($risk_score, 2),
        ]);
    
        return view('hasil', compact('hasil', 'data'))->with('skor', round($risk_score, 2));
    }


    public function exportPDF()
    {
        $hasil = session('hasil');
        $data = session('data');
        $skor = session('skor');

        if (!$hasil || !$data || !$skor) {
            return redirect()->route('form')->with('error', 'Tidak ada data diagnosa untuk di-export.');
        }

        $pdf = Pdf::loadView('hasil_pdf', compact('hasil', 'data', 'skor'))->setPaper('a4', 'portrait');
        return $pdf->download('hasil_diagnosa.pdf');
    }
    public function riwayat()
    {
    $user = auth()->user();
    $riwayat = \App\Models\Diagnosa::where('user_id', $user->id)->latest()->get();

    return view('diagnosa.riwayat', compact('riwayat'));
    }
    public function process_chatbot(Request $request)
{
    $message = $request->input('message');
    $chat_input = $request->input('chat_input', []);

    Log::info('Input message:', ['message' => $message]);
    Log::info('Input chat_input:', $chat_input);

    // Kirim ke model Python
    $response = Http::post('http://127.0.0.1:8001/chatbot', [
        'message' => $message,
        'chat_input' => $chat_input
    ]);

    $result = $response->json();

    \Log::debug('Response dari Python:', $result);

    $tag = $result['tag'] ?? null;
    $parsed_value = $result['parsed_value'] ?? null;
    $parsed_color_value = $result['parsed_color_value'] ?? null; // 🔥 tambahkan ini

    $tag_to_field = [
        'input_usia' => 'usia',
        'input_suhu_tubuh' => 'suhu_tubuh',
        'input_tekanan_darah' => 'tekanan_darah',
        'input_asam_urat' => 'asam_urat',
        'input_kadar_urine' => 'kadar_urine',
        'input_warna_urine' => 'warna_urine',
        'input_konsumsi_air' => 'konsumsi_air_putih',
    ];

    $rules = [
        'usia' => 'required|integer|min:0|max:120',
        'suhu_tubuh' => 'required|numeric|between:30,45',
        'tekanan_darah' => 'required|numeric|min:70|max:200',
        'asam_urat' => 'required|numeric|min:0|max:20',
        'kadar_urine' => 'required|numeric|min:0|max:1000',
        'warna_urine' => 'required|in:jernih,kuning,keruh',
        'konsumsi_air_putih' => 'required|integer|min:0|max:20',
    ];

    if ($tag && (isset($parsed_value) || isset($parsed_color_value))) {
        if (!isset($tag_to_field[$tag])) {
            return response()->json([
                'reply' => "Terjadi kesalahan: tag *$tag* tidak dikenali.",
                'chat_input' => $chat_input
            ]);
        }

        $field = $tag_to_field[$tag];

        // 🔥 Gunakan parsed_color_value jika tag-nya adalah input_warna_urine
        $value_to_validate = $tag === 'input_warna_urine' ? $parsed_color_value : $parsed_value;

        if (!isset($rules[$field])) {
            return response()->json([
                'reply' => "Terjadi kesalahan: aturan validasi untuk *$field* tidak ditemukan.",
                'chat_input' => $chat_input
            ]);
        }

        $validator = Validator::make([$field => $value_to_validate], [
            $field => $rules[$field]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'reply' => "Mohon isi data *$field* dengan benar.",
                'error' => $validator->errors()->first($field),
                'field' => $field,
                'chat_input' => $chat_input
            ]);
        }

        // 🔥 Simpan nilai yang sudah divalidasi ke chat_input
        $chat_input[$field] = $value_to_validate;

        \Log::debug("Field '$field' berhasil disimpan dengan nilai:", [$value_to_validate]);
    }

    foreach (['usia', 'suhu_tubuh', 'tekanan_darah', 'asam_urat', 'kadar_urine', 'warna_urine', 'konsumsi_air_putih'] as $field) {
        if (!isset($chat_input[$field])) {
            return response()->json([
                'reply' => "Silakan isi data *$field* terlebih dahulu.",
                'ask_field' => $field,
                'chat_input' => $chat_input
            ]);
        }
    }


    

    return response()->json([
        'reply' => "Terima kasih, semua data sudah lengkap. Siap untuk diagnosa.",
        'complete' => true,
        'chat_input' => $chat_input
    ]);
}

public function submitBinaryQuestions(Request $request)
    {
        // Aturan validasi sesuai request kamu
        $rules = [
            'nyeri_pinggang'      => 'required|in:Ya,Tidak',
            'sering_berkemih'     => 'required|in:Ya,Tidak',
            'mudah_lelah'         => 'required|in:Ya,Tidak',
            'mual_muntah'         => 'required|in:Ya,Tidak',
            'riwayat_ginjal'      => 'required|in:Ya,Tidak',
            'riwayat_hipertensi'  => 'required|in:Ya,Tidak',
            'riwayat_diabetes'    => 'required|in:Ya,Tidak',
        ];

        // Validasi input
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan error
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Jika validasi berhasil, proses data sesuai kebutuhan
        $data = $validator->validated();

        // Contoh: Simpan data ke database atau proses lain

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diterima',
            'data' => $data,
        ]);
    }


private function hitungRisikoSkor($data)
{
    // Fuzzy membership scores
    $usia_score = $this->fuzzyUsia($data['usia']);
    $suhu_score = $this->fuzzySuhu($data['suhu_tubuh']);
    $tekanan_score = $this->fuzzyTekanan($data['tekanan_darah']);
    $asam_score = $this->fuzzyAsamUrat($data['asam_urat']);
    $urine_score = $this->fuzzyUrine($data['kadar_urine']);
    $air_score = $this->fuzzyAirPutih($data['konsumsi_air_putih']);

    // Convert gejala Ya/Tidak ke skor 0 atau 1
    $gejala = collect([
        'nyeri_pinggang' => $data['nyeri_pinggang'] === 'Ya' ? 1 : 0,
        'sering_berkemih' => $data['sering_berkemih'] === 'Ya' ? 1 : 0,
        'mudah_lelah' => $data['mudah_lelah'] === 'Ya' ? 1 : 0,
        'mual_muntah' => $data['mual_muntah'] === 'Ya' ? 1 : 0,
        'riwayat_ginjal' => $data['riwayat_ginjal'] === 'Ya' ? 1 : 0,
        'riwayat_hipertensi' => $data['riwayat_hipertensi'] === 'Ya' ? 1 : 0,
        'riwayat_diabetes' => $data['riwayat_diabetes'] === 'Ya' ? 1 : 0,
    ])->sum() / 7;

    // Skor risiko gabungan (defuzzification)
    $risk_score = (
        $usia_score * 0.1 +
        $suhu_score * 0.1 +
        $tekanan_score * 0.1 +
        $asam_score * 0.15 +
        $urine_score * 0.15 +
        $air_score * 0.1 +
        $gejala * 0.3
    );

    // Interpretasi hasil
    if ($risk_score >= 0.7) {
        $hasil = "Kemungkinan gangguan ginjal. Disarankan konsultasi ke dokter.";
    } elseif ($risk_score >= 0.4) {
        $hasil = "Perlu waspada. Perhatikan gaya hidup dan konsultasi jika perlu.";
    } else {
        $hasil = "Tidak terindikasi gangguan ginjal berdasarkan data yang diberikan.";
    }

    return [
        'skor' => round($risk_score, 2),
        'hasil' => $hasil,
    ];
}

   

}