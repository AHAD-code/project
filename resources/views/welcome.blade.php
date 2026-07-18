<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to PEL Internship Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        pel: {
                            blue: '#005baa', // PEL Corporate Blue
                            dark: '#0a2540',
                            light: '#f0f6ff',
                            accent: '#f59e0b'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-gray-800 font-inter" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navigation -->
    <nav :class="{ 'bg-white shadow-md py-3': scrolled, 'bg-transparent py-5': !scrolled }" class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pel-blue rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white font-poppins font-bold text-xl tracking-wider">PEL</span>
                </div>
                <span :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }" class="font-poppins font-bold text-xl hidden sm:block transition-colors">
                    Internship Portal
                </span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#about" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium transition-colors">About PEL</a>
                <a href="#programs" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium transition-colors">Programs</a>
                <a href="#benefits" :class="{ 'text-gray-600 hover:text-pel-blue': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="font-medium transition-colors">Why Join</a>

                <div class="flex items-center gap-4 border-l border-gray-300 pl-6">
                    <!-- Fallback standard URLs to prevent Route errors -->
                    <a href="/login" :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }" class="font-medium hover:opacity-80 transition-opacity">Log in</a>
                    <a href="/register" class="px-5 py-2.5 bg-pel-blue text-white rounded-xl font-semibold shadow-lg shadow-pel-blue/30 hover:bg-blue-700 transition-all">Apply Now</a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md" :class="{ 'text-pel-dark': scrolled, 'text-white': !scrolled }">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100 py-4 px-6 flex flex-col gap-4">
            <a href="#about" @click="mobileMenuOpen = false" class="text-gray-700 font-medium">About PEL</a>
            <a href="#programs" @click="mobileMenuOpen = false" class="text-gray-700 font-medium">Programs</a>
            <a href="/login" class="text-pel-blue font-semibold">Log in</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <!-- Using a high quality industrial/engineering placeholder image -->
            <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80" alt="Engineering Background" class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-pel-dark/80 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-pel-dark via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center text-white">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-8">
                <span class="w-2 h-2 rounded-full bg-pel-accent animate-pulse"></span>
                <span class="text-sm font-medium tracking-wide">Applications Open for Summer 2026</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-poppins font-bold tracking-tight mb-6 leading-tight">
                Shape the Future with <br> <span class="text-pel-blue bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-pel-blue">Pak Elektron Limited</span>
            </h1>

            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 font-light">
                Join Pakistan's leading manufacturer of electrical equipment and home appliances. Our IMS portal connects aspiring engineers and professionals with industry-leading mentors.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="/register" class="w-full sm:w-auto px-8 py-4 bg-pel-blue text-white rounded-xl font-bold text-lg shadow-[0_0_40px_rgba(0,91,170,0.4)] hover:bg-blue-700 hover:-translate-y-1 transition-all">
                    Start Your Journey
                </a>
                <a href="#about" class="w-full sm:w-auto px-8 py-4 bg-white/10 text-white border border-white/20 backdrop-blur-md rounded-xl font-bold text-lg hover:bg-white/20 transition-all">
                    Explore Programs
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-pel-dark py-12 border-b border-white/10 relative z-20 shadow-xl">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/10">
            <div>
                <h3 class="text-4xl font-poppins font-bold text-white mb-2">60+</h3>
                <p class="text-pel-blue font-medium">Years of Excellence</p>
            </div>
            <div>
                <h3 class="text-4xl font-poppins font-bold text-white mb-2">500+</h3>
                <p class="text-pel-blue font-medium">Interns Annually</p>
            </div>
            <div>
                <h3 class="text-4xl font-poppins font-bold text-white mb-2">2</h3>
                <p class="text-pel-blue font-medium">Major Divisions (Appliance & Power)</p>
            </div>
            <div>
                <h3 class="text-4xl font-poppins font-bold text-white mb-2">80%</h3>
                <p class="text-pel-blue font-medium">Placement Rate</p>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-24 bg-pel-light">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2 relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-pel-blue to-blue-400 rounded-2xl transform rotate-3 opacity-20 blur-lg"></div>
                <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80" alt="PEL Factory" class="relative rounded-2xl shadow-2xl object-cover h-[400px] w-full" />
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-pel-blue font-bold tracking-wider uppercase text-sm mb-2">About PEL</h2>
                <h3 class="text-3xl md:text-4xl font-poppins font-bold text-gray-900 mb-6">Pioneers in Pakistan's Engineering Sector</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Pak Elektron Limited (PEL) is the pioneer manufacturer of electrical goods in Pakistan. Established in 1956, PEL comprises two distinct divisions: <strong>Appliances Division</strong> and <strong>Power Division</strong>.
                </p>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Our internship program is designed to provide hands-on experience in real-world industrial environments. You will work alongside industry veterans, gaining practical knowledge that bridges the gap between academic theory and professional application.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-pel-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-gray-700 font-medium">State-of-the-art manufacturing facilities</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-pel-blue">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-gray-700 font-medium">Direct mentorship from technical supervisors</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programs" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-pel-blue font-bold tracking-wider uppercase text-sm mb-2">Available Domains</h2>
                <h3 class="text-3xl md:text-4xl font-poppins font-bold text-gray-900 mb-4">Choose Your Path at PEL</h3>
                <p class="text-gray-600">We offer specialized 6-week and 12-week internship programs across multiple disciplines.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Program 1 -->
                <div class="group bg-white rounded-2xl border border-gray-100 p-8 hover:shadow-xl hover:border-pel-blue/30 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 text-pel-blue rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Core Engineering</h4>
                    <p class="text-gray-600 mb-6 text-sm">Work directly in our Power and Appliance divisions. Focus areas include Electrical, Mechanical, and Industrial engineering.</p>
                    <a href="/register" class="text-pel-blue font-semibold inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                        Apply Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Program 2 -->
                <div class="group bg-white rounded-2xl border border-gray-100 p-8 hover:shadow-xl hover:border-pel-blue/30 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 text-pel-blue rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">IT & Software</h4>
                    <p class="text-gray-600 mb-6 text-sm">Help build and maintain enterprise applications like this IMS, ERP systems, and internal corporate infrastructure.</p>
                    <a href="/register" class="text-pel-blue font-semibold inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                        Apply Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>

                <!-- Program 3 -->
                <div class="group bg-white rounded-2xl border border-gray-100 p-8 hover:shadow-xl hover:border-pel-blue/30 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-50 text-pel-blue rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3">Business & SCM</h4>
                    <p class="text-gray-600 mb-6 text-sm">Join our Supply Chain, Human Resources, or Marketing departments to understand the commercial side of manufacturing.</p>
                    <a href="/register" class="text-pel-blue font-semibold inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                        Apply Now <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-pel-dark text-gray-300 py-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-pel-blue rounded-lg flex items-center justify-center">
                        <span class="text-white font-poppins font-bold">PEL</span>
                    </div>
                    <span class="font-poppins font-semibold text-white">Internship Management System</span>
                </div>

                <div class="flex gap-6 text-sm">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-white transition-colors">Contact HR</a>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-500 border-t border-white/10 pt-8">
                &copy; {{ date('Y') }} Pak Elektron Limited (PEL). All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
