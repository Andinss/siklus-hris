<!-- resources/views/auth/create-password.blade.php -->
<form action="{{ route('registerEmployee') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ request('token') }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <label for="password">Kata Sandi Baru</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
    <input type="password" name="password_confirmation" required>

    <button type="submit">Buat Kata Sandi</button>
</form>
