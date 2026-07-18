<x-guest-layout>
    <style>
        /* Shared Glassmorphism styles */
        .glass-card {
            width: 90%;
            max-width: 500px; /* Slightly wider for registration forms */
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2.5rem;
            border-radius: 24px;
            color: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            outline: none;
            margin-top: 5px;
        }

        /* Radio Group Styling */
        .radio-group { display: flex; gap: 10px; margin-top: 10px; }
        .radio-option {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="radio"]:checked + .radio-option {
            background: white;
            color: #4c1d95;
            font-weight: bold;
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
            margin-top: 20px;
            transition: transform 0.2s;
        }
    </style>

    <div class="min-h-screen flex items-center justify-center p-4"
         style="background: linear-gradient(to bottom, #6d28d9, #4c1d95, #1e1b4b);">

        <div class="glass-card">
            <h2 class="text-3xl font-bold text-center mb-6">Create Account</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role Selection -->
                <div class="mb-4">
                    <label class="text-sm opacity-80">I am registering as a:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="role" value="student" class="hidden" checked>
                            <div class="radio-option">Student</div>
                        </label>
                        <label>
                            <input type="radio" name="role" value="supervisor" class="hidden">
                            <div class="radio-option">Supervisor</div>
                        </label>
                    </div>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                </div>

                <!-- Passwords -->
                <div class="mb-4">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>

                <button type="submit">Register Account</button>
            </form>

            <p class="text-center text-sm mt-6">
                Already have an account? <a href="{{ route('login') }}" class="font-bold underline">Log in</a>
            </p>
        </div>
    </div>
</x-guest-layout>
