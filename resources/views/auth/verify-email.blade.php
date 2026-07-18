<x-guest-layout>
    <style>
        .glass-card {
            width: 90%;
            max-width: 450px; /* Slightly wider for the text paragraph */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2.5rem 2rem;
            border-radius: 24px;
            color: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .primary-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 25px;
            background: white;
            color: #4c1d95;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1rem;
        }

        .primary-btn:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .logout-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9rem;
            transition: color 0.3s;
            padding: 0;
            width: auto;
        }

        .logout-btn:hover {
            color: white;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #bbf7d0;
            padding: 12px;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>

    <div class="min-h-screen flex items-center justify-center p-4"
         style="background: linear-gradient(to bottom, #6d28d9, #4c1d95, #1e1b4b);">

        <div class="glass-card">
            <h2 class="text-3xl font-bold text-center mb-4">Verify Your Email</h2>

            <p class="text-sm text-center mb-6" style="color: rgba(255, 255, 255, 0.85); line-height: 1.6;">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="alert-success">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex flex-col items-center">
                <!-- Resend Verification Email Form -->
                <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                    @csrf
                    <button type="submit" class="primary-btn">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <!-- Log Out Form -->
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="logout-btn">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
