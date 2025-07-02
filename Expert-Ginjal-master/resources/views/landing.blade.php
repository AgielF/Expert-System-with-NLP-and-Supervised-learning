<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Pakar Deteksi Ginjal</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white text-gray-900">

    <!-- Navbar -->
   <!-- Navbar -->
<header x-data="{ open: false }" class="fixed inset-x-0 top-0 z-50 bg-white shadow-md">
    <nav class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="#" class="flex items-center gap-2 text-indigo-600 font-bold text-lg">
                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-8">
                Expert System
            </a>
        </div>
        <div class="hidden lg:flex items-center space-x-8">
            <a href="#" class="text-sm font-medium hover:text-indigo-600 transition">Deskripsi Penyakit</a>
            <a href="/chatbot" class="text-sm font-medium hover:text-indigo-600 transition">Chatbot</a>  <!-- Nav Chatbot ditambah -->
        </div>
        <div class="lg:hidden">
            <button @click="open = !open" class="p-2 text-gray-600 rounded hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>
    <div x-show="open" class="lg:hidden px-4 pb-4 space-y-2">
        <a href="#" class="block text-sm font-medium hover:text-indigo-600">Deskripsi Penyakit</a>
        <a href="#" class="block text-sm font-medium hover:text-indigo-600">Chatbot</a>  <!-- Nav Chatbot mobile -->
        <a href="#" class="block text-sm font-medium hover:text-indigo-600">Log in</a>
    </div>
</header>


    <!-- Hero Section -->
    <section class="relative isolate pt-32 pb-24 sm:pt-40 sm:pb-32 lg:pb-40 overflow-hidden">
        <div class="absolute inset-0 -z-10 overflow-hidden blur-3xl">
            <div class="absolute left-1/2 top-[-15rem] sm:top-[-25rem] w-[72rem] h-[72rem] -translate-x-1/2 bg-gradient-to-tr from-pink-300 via-purple-300 to-indigo-400 opacity-30 rounded-full"></div>
        </div>

        <div class="max-w-3xl mx-auto px-6 text-center">
            <p class="mb-4 inline-block rounded-full bg-indigo-100 px-4 py-1 text-sm font-medium text-indigo-700">
                Informasi Mengenai Penyakit Ginjal
            </p>
            <h1 class="text-4xl sm:text-6xl font-bold leading-tight tracking-tight text-gray-900">
                Sistem Pakar Deteksi Penyakit Ginjal
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-gray-600">
                Sistem ini dirancang untuk membantu Anda mengenali gejala awal penyakit ginjal secara cepat dan akurat menggunakan logika fuzzy.
            </p>
            <div class="mt-10 flex justify-center gap-4">
                <a href="/form" class="inline-block rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500 transition">
                    Mulai Deteksi
                </a>
                <a href="#" class="inline-block rounded-md border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-50 py-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Mengapa Menggunakan Sistem Ini?</h2>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                Kami menyediakan pendekatan sederhana namun canggih untuk mendeteksi potensi gangguan ginjal berdasarkan gejala yang Anda alami.
            </p>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12 text-left">
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-3 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Deteksi Dini</h3>
                    <p class="text-gray-600">Mendeteksi potensi penyakit ginjal sebelum gejala menjadi parah.</p>
                </div>
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-3 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4 -4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Berbasis Fuzzy Logic</h3>
                    <p class="text-gray-600">Menggunakan metode kecerdasan buatan untuk akurasi yang lebih tinggi.</p>
                </div>
                <div class="flex flex-col items-center md:items-start text-center md:text-left">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-3 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1 0V9h1m-4 11a9 9 0 1118 0 9 9 0 01-18 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Mudah Digunakan</h3>
                    <p class="text-gray-600">Antarmuka ramah pengguna, cocok untuk siapa saja tanpa latar belakang medis.</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
