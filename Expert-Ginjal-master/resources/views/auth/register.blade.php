@extends('components.layout')

@section('content')
<div class="container mx-auto mt-10 max-w-md p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <label for="username" class="block font-semibold mb-1">Username</label>
        <input type="text" name="username" class="w-full border rounded p-2 mb-4" required>

        <label for="password" class="block font-semibold mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2 mb-4" required>

        <label for="password_confirmation" class="block font-semibold mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2 mb-4" required>

        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">Register</button>

        <p class="mt-4 text-sm text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600">Login</a></p>
    </form>
</div>
@endsection
