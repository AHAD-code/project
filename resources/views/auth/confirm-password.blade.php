<x-guest-layout>
    <style>
        .glass-card {
            width: 90%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2.5rem 2rem;
            border-radius: 24px;
            color: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .form-group { margin-bottom: 1.2rem; }

        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
        }

        input[type="password"]::placeholder {
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
            margin-top: 0.5rem;
        }

        button:hover { transform: scale(1.02); }

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
            <h2 class="text-3xl font-bold text-center mb-4">Secure Area</h2>

            <p class="text-sm text-center mb-6" style="color: rgba(255, 255, 255, 0.85); line-height: 1.6;">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="form-group">
                    <input id="password" type="password" name="password" placeholder="Password" required autocomplete="current-password">

                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit">
                    {{ __('Confirm') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
