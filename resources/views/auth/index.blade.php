<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - eduSantri</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: white;
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: white;
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            bottom: -50px;
            right: -50px;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Background Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <!-- Login Container -->
    <div class="w-full max-w-md relative z-10">
        
        <!-- Logo and Title -->
        <div class="text-center mb-8 floating">
            <div class="inline-block bg-white rounded-full p-6 shadow-2xl mb-4">
                <i class="fas fa-graduation-cap text-6xl text-purple-600"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">eduSantri</h1>
            <p class="text-purple-100">Sistem Informasi Manajemen Pesantren</p>
        </div>

        <!-- Login Card -->
        <div class="login-card rounded-2xl shadow-2xl p-8">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                <p class="text-gray-600">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p class="text-red-800 font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-purple-600"></i>Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('email') border-red-500 @enderror"
                        placeholder="nama@example.com">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-purple-600"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password">
                        <button 
                            type="button" 
                            onclick="togglePassword()" 
                            class="absolute right-3 top-3 text-gray-500 hover:text-gray-700 transition duration-200">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium transition duration-200">
                        Lupa password?
                    </a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition duration-200 transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </button>
            </form>

            <!-- Demo Accounts -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm font-semibold text-gray-700 mb-4 text-center">Akun Demo untuk Testing:</p>
                
                <div class="grid grid-cols-2 gap-3">
                    <!-- Admin Demo -->
                    <button 
                        onclick="fillCredentials('admin@edusantri.com', 'admin123')"
                        class="bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg p-3 transition duration-200 text-left">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-user-shield text-red-600 mr-2"></i>
                            <span class="text-sm font-semibold text-red-700">Admin</span>
                        </div>
                        <p class="text-xs text-gray-600">Full Access</p>
                    </button>

                    <!-- Teacher Demo -->
                    <button 
                        onclick="fillCredentials('teacher@edusantri.com', 'teacher123')"
                        class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-3 transition duration-200 text-left">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i>
                            <span class="text-sm font-semibold text-blue-700">Guru</span>
                        </div>
                        <p class="text-xs text-gray-600">Teacher Access</p>
                    </button>

                    <!-- Staff Demo -->
                    <button 
                        onclick="fillCredentials('staff@edusantri.com', 'staff123')"
                        class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-3 transition duration-200 text-left">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-user-tie text-green-600 mr-2"></i>
                            <span class="text-sm font-semibold text-green-700">Staff</span>
                        </div>
                        <p class="text-xs text-gray-600">Staff Access</p>
                    </button>

                    <!-- Student Demo -->
                    <button 
                        onclick="fillCredentials('student@edusantri.com', 'student123')"
                        class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-3 transition duration-200 text-left">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-user-graduate text-purple-600 mr-2"></i>
                            <span class="text-sm font-semibold text-purple-700">Siswa</span>
                        </div>
                        <p class="text-xs text-gray-600">Student Access</p>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-white">
            <p class="text-sm opacity-90">© {{ date('Y') }} eduSantri. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Fill demo credentials
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            
            // Show notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
            notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Kredensial demo telah diisi!';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        }

        // Auto-hide success messages
        setTimeout(() => {
            const successMsg = document.querySelector('.bg-green-50');
            if (successMsg) {
                successMsg.style.transition = 'opacity 0.5s';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>