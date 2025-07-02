<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chatbot</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-md flex flex-col h-[600px]">
        <!-- Header -->
        <div class="bg-indigo-600 text-white px-4 py-3 rounded-t-lg font-semibold text-lg">
            Chatbot Expert System
        </div>
<div id="chatMessages" class="flex flex-col gap-2 p-4 h-96 overflow-y-auto bg-gray-100 rounded-md"></div>

<form id="chatForm" class="flex border-t border-gray-300 px-4 py-3">
    <input id="messageInput" type="text" placeholder="Tulis pesan..." required
           class="flex-1 border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 rounded-r-md">
        Kirim
    </button>
</form>

<form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
    @csrf
    <button type="submit"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-md">
        Logout
    </button>
</form>
<script>
const chatForm = document.getElementById('chatForm');
const messageInput = document.getElementById('messageInput');
const chatMessages = document.getElementById('chatMessages');

let chatInputData = {};
let step = 'numeric'; // 'numeric' atau 'binary' atau 'done'

const numericFields = [
  'usia', 'suhu_tubuh', 'tekanan_darah', 'asam_urat', 'kadar_urine', 'warna_urine', 'konsumsi_air_putih'
];

const binaryFields = [
  'nyeri_pinggang',
  'sering_berkemih',
  'mudah_lelah',
  'mual_muntah',
  'riwayat_ginjal',
  'riwayat_hipertensi',
  'riwayat_diabetes',
];

let currentBinaryIndex = 0;

chatForm.addEventListener('submit', async function(e) {
  e.preventDefault();

  const userMessage = messageInput.value.trim();
  if (!userMessage) return;

  addMessage(userMessage, 'user');
  messageInput.value = '';

  try {
    if (step === 'numeric') {
      // Kirim data numeric ke /chatbot
      const response = await fetch('http://127.0.0.1:8000/chatbot', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // aktifkan kalau perlu di Laravel Blade
        },
        body: JSON.stringify({
          message: userMessage,
          chat_input: chatInputData
        })
      });

      if (!response.ok) throw new Error('Terjadi kesalahan di server.');

      const data = await response.json();

      if (data.reply) addMessage(data.reply, 'bot');
      if (data.error) addMessage(`⚠️ Error: ${data.error}`, 'bot');

      if (data.chat_input && typeof data.chat_input === 'object') {
        chatInputData = { ...chatInputData, ...data.chat_input };
        addMessage(`(Data saat ini: ${JSON.stringify(chatInputData)})`, 'bot');
      }

      // Cek apakah semua numeric field sudah terisi
      const allNumericFilled = numericFields.every(field => field in chatInputData);

      if (allNumericFilled) {
        step = 'binary';
        addMessage('Sekarang saya akan menanyakan beberapa pertanyaan Ya/Tidak. Silakan jawab dengan "Ya" atau "Tidak".', 'bot');
        addMessage(`Pertanyaan 1: ${formatBinaryQuestion(binaryFields[0])}`, 'bot');
      }

    } else if (step === 'binary') {
      // Validasi jawaban binary (harus Ya/Tidak)
      if (userMessage.toLowerCase() !== 'ya' && userMessage.toLowerCase() !== 'tidak') {
        addMessage('Mohon jawab hanya dengan "Ya" atau "Tidak".', 'bot');
        return;
      }

      // Simpan jawaban binary
      chatInputData[binaryFields[currentBinaryIndex]] = capitalize(userMessage);

      currentBinaryIndex++;

      if (currentBinaryIndex < binaryFields.length) {
        addMessage(`Pertanyaan ${currentBinaryIndex + 1}: ${formatBinaryQuestion(binaryFields[currentBinaryIndex])}`, 'bot');
      } else {
        // Semua binary sudah terisi, submit ke /submitBinaryQuestions
        addMessage('Terima kasih atas jawabannya. Memproses data...', 'bot');

        const submitResponse = await fetch('http://127.0.0.1:8000/submitBinaryQuestions', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // aktifkan jika perlu
          },
          body: JSON.stringify(chatInputData)
        });

        const submitData = await submitResponse.json();

        if (submitResponse.ok && submitData.status === 'success') {
          addMessage('Data berhasil diterima. Proses diagnosa bisa dilanjutkan.', 'bot');
          step = 'done';
        } else {
          addMessage('Terjadi kesalahan saat mengirim data binary:', 'bot');
          if(submitData.errors){
            for(const [field, messages] of Object.entries(submitData.errors)){
              addMessage(`${field}: ${messages.join(', ')}`, 'bot');
            }
          }
          // Bisa reset atau minta ulang jawaban binary yg salah
          // Contoh: reset currentBinaryIndex supaya tanya ulang mulai dari pertanyaan error
        }
      }
    } else if (step === 'done') {
      addMessage('Data sudah lengkap dan proses selesai. Terima kasih!', 'bot');
    }

  } catch (error) {
    addMessage('Maaf, terjadi kesalahan: ' + error.message, 'bot');
  }

  messageInput.focus();
});

function addMessage(text, sender = 'bot') {
  const msgDiv = document.createElement('div');
  msgDiv.classList.add('max-w-xs', 'px-4', 'py-2', 'rounded-lg', 'text-white', 'break-words', 'whitespace-pre-wrap');

  if (sender === 'user') {
    msgDiv.classList.add('bg-indigo-600', 'self-end');
  } else {
    msgDiv.classList.add('bg-gray-600', 'self-start');
  }

  msgDiv.textContent = text;
  chatMessages.appendChild(msgDiv);
  chatMessages.scrollTop = chatMessages.scrollHeight;
}

function formatBinaryQuestion(field) {
  // Bisa diubah sesuai pertanyaan yang kamu mau tampilkan
  const questionMap = {
    'nyeri_pinggang': 'Apakah Anda merasakan nyeri pinggang?',
    'sering_berkemih': 'Apakah Anda sering berkemih?',
    'mudah_lelah': 'Apakah Anda mudah lelah?',
    'mual_muntah': 'Apakah Anda mengalami mual atau muntah?',
    'riwayat_ginjal': 'Apakah Anda memiliki riwayat penyakit ginjal?',
    'riwayat_hipertensi': 'Apakah Anda memiliki riwayat hipertensi?',
    'riwayat_diabetes': 'Apakah Anda memiliki riwayat diabetes?',
  };
  return questionMap[field] || field;
}

function capitalize(str) {
  if (!str) return str;
  return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
}

// Mulai dengan tanya data numeric pertama jika kamu mau
addMessage('Halo! Silakan isi data berikut terlebih dahulu:', 'bot');
addMessage('Masukkan ' + numericFields[0].replace(/_/g, ' ') + ':', 'bot');

</script>


</body>
</html>
