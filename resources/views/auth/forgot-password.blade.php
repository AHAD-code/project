<x-guest-layout>
    <style>
        .glass-card {
            width: 90%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
            border-radius: 24px;
            color: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .form-group { margin-bottom: 1.2rem; }

        input[type="email"] {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        input[type="email"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 25px;
            background: white;
            color: #4c1d95;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover { transform: scale(1.02); }

        /* Custom styling for success and error messages on dark backgrounds */
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

        .error-text {
            color: #fca5a5;
            font-size: 0.85rem;
            margin-top: 6px;
            padding-left: 12px;
        }
    </style>

    <div class="min-h-screen flex items-center justify-center p-4"
         style="background: linear-gradient(to bottom, #6d28d9, #4c1d95, #1e1b4b);">

        <div class="glass-card">
            <h2 class="text-3xl font-bold text-center mb-4">Reset Password</h2>

            <p class="text-sm text-center mb-6" style="color: rgba(255, 255, 255, 0.8); line-height: 1.6;">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required autofocus>

                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="mt-2">
                    {{ __('Email Password Reset Link') }}
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color: rgba(255, 255, 255, 0.8);">
                Remember your password? <a href="{{ route('login') }}" class="font-bold text-white hover:underline">Back to Login</a>
            </p>
        </div>
    </div>
</x-guest-layout>
