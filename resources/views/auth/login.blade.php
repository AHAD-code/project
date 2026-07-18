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

            /* Consistent Radio Group Styling */
            .radio-group { display: flex; gap: 10px; margin-bottom: 1.2rem; }
            .radio-option {
                flex: 1;
                text-align: center;
                padding: 10px;
                border-radius: 25px;
                background: rgba(255, 255, 255, 0.1);
                cursor: pointer;
                transition: 0.3s;
                font-size: 0.9rem;
            }
            input[type="radio"]:checked + .radio-option {
                background: white;
                color: #4c1d95;
                font-weight: bold;
            }

            .form-group { margin-bottom: 1.2rem; }

            input[type="email"], input[type="password"] {
                width: 100%;
                padding: 12px 20px;
                border: none;
                border-radius: 25px;
                background: rgba(255, 255, 255, 0.1);
                color: white;
                outline: none;
            }

            .custom-checkbox { accent-color: #6d28d9; width: 18px; height: 18px; cursor: pointer; }

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
        </style>

        <div class="min-h-screen flex items-center justify-center p-4"
            style="background: linear-gradient(to bottom, #6d28d9, #4c1d95, #1e1b4b);">

            <div class="glass-card">
                <h2 class="text-3xl font-bold text-center mb-6">Login</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Role Selection (Aligned with Register interface) -->
                <div class="radio-group">
        <label class="flex-1">
            <!-- Make sure the name is 'role_login_type' -->
            <input type="radio" name="role_login_type" value="student" class="hidden" checked>
            <div class="radio-option">Student</div>
        </label>
        <label class="flex-1">
            <input type="radio" name="role_login_type" value="supervisor" class="hidden">
            <div class="radio-option">Supervisor</div>
        </label>
    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="flex justify-between items-center mb-6 px-2 text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="custom-checkbox">
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit">Login</button>
                </form>

                <p class="text-center text-sm mt-6">
                    Don't have an account? <a href="{{ route('register') }}" class="font-bold underline">Register</a>
                </p>
            </div>
        </div>
    </x-guest-layout>
