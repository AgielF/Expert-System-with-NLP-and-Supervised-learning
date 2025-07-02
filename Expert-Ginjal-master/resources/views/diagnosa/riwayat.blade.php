@extends('components.layout')

@section('content')
    <div class="container">
        <h2 class="text-lg font-semibold mb-4">Riwayat Diagnosa</h2>

        @if($riwayat->isEmpty())
            <p class="text-gray-600">Tidak ada riwayat diagnosa.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Usia</th>
                            <th class="px-4 py-2 text-left">Suhu</th>
                            <th class="px-4 py-2 text-left">Tekanan Darah</th>
                            <th class="px-4 py-2 text-left">Hasil</th>
                            <th class="px-4 py-2 text-left">Skor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($riwayat as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-4 py-2">{{ $item->usia }}</td>
                                <td class="px-4 py-2">{{ $item->suhu_tubuh }}</td>
                                <td class="px-4 py-2">{{ $item->tekanan_darah }}</td>
                                <td class="px-4 py-2">{{ $item->hasil_diagnosa }}</td>
                                <td class="px-4 py-2">{{ $item->skor }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
