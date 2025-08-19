<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-xl shadow-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">OTP Verification</h2>

        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
            @csrf

            <div>
                <label for="otp" class="block text-gray-700 text-sm font-medium mb-2">
                    Enter the OTP sent to your email:
                </label>
                <input
                    type="text"
                    name="otp"
                    id="otp"
                    maxlength="6"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="123456"
                >
            </div>

            @if($errors->any())
                <div class="text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Verify OTP
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p id="timer" class="text-sm text-gray-600">Resend OTP in <span id="countdown">60</span> seconds</p>

            <form method="POST" action="{{ route('login') }}" id="resendForm" class="hidden mt-2">
                @csrf
                <input type="hidden" name="email" value="{{ session('auth_email') }}">
                <input type="hidden" name="password" value="{{ session('auth_password') }}">
                <button type="submit" class="text-blue-600 hover:underline text-sm font-medium">
                    Resend OTP
                </button>
            </form>
        </div>
    </div>

    <script>
        let countdown = 60;
        const countdownEl = document.getElementById("countdown");
        const timerText = document.getElementById("timer");
        const resendForm = document.getElementById("resendForm");

        const interval = setInterval(() => {
            countdown--;
            countdownEl.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                timerText.classList.add('hidden');
                resendForm.classList.remove('hidden');
            }
        }, 1000);

        window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        e.returnValue = 'If you refresh, you will need to log in again.';
    });
    </script>
</x-guest-layout>

