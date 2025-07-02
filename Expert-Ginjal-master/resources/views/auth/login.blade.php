@extends('components.layout')

@section('content')
<div class="container mx-auto mt-10 max-w-md p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <label for="username" class="block font-semibold mb-1">Username</label>
        <input type="text" name="username" class="w-full border rounded p-2 mb-4" required>

        <label for="password" class="block font-semibold mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2 mb-4" required>

        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Login</button>

        <p class="mt-4 text-sm text-center">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600">Register</a></p>
    </form>
</div>
@endsection
