document.addEventListener('DOMContentLoaded', function () {
    const usiaInput = document.getElementById('usia');
    const usiaError = document.getElementById('usia-error');

    usiaInput.addEventListener('input', function () {
        const value = parseInt(usiaInput.value);
        if (value < 0 || value > 120) {
            usiaError.classList.remove('hidden');
        } else {
            usiaError.classList.add('hidden');
        }
    });
});