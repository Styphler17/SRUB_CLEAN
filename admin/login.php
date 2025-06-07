<?php
session_start();

require_once '../app/config/params.php';
require_once 'includes/functions.php';
$pdo = $connexion;

$error = '';

global $themeColors;

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            // Set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['admin_picture'] = $admin['picture'];
            // Log the login activity
            log_admin_activity($pdo, $_SESSION['admin_id'], 'Logged in');
            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Cleanesta Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/assets/images/logo/cleanesta-services-logo.png" type="image/png">
</head>

<body class="bg-purple-50 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Orbiting Background Patterns -->
    <div class="orbit-bg-container">
        <img src="/assets/images/patterns/pattern-1.png" alt="Pattern 1" class="orbit-pattern orbit1" aria-hidden="true">
        <img src="/assets/images/patterns/pattern-2.png" alt="Pattern 2" class="orbit-pattern orbit2" aria-hidden="true">
        <img src="/assets/images/patterns/pattern-3.png" alt="Pattern 3" class="orbit-pattern orbit3" aria-hidden="true">
        <img src="/assets/images/patterns/pattern-4.png" alt="Pattern 4" class="orbit-pattern orbit4" aria-hidden="true">
    </div>
    <style>
        .orbit-bg-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
        }

        .orbit-pattern {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 140px;
            height: 140px;
            opacity: 0.13;
            border-radius: 100%;
            border: 2px solid <?php echo $themeColors['primary'] ?? '#f34d26'; ?>;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.02);
            transition: opacity 0.3s;
            object-fit: cover;
        }

        .orbit1 {
            animation: orbit1 22s linear infinite;
        }

        .orbit2 {
            animation: orbit2 22s linear infinite;
        }

        .orbit3 {
            animation: orbit3 22s linear infinite;
        }

        .orbit4 {
            animation: orbit4 22s linear infinite;
        }

        @keyframes orbit1 {
            0% {
                transform: translate(-50%, -50%) rotate(0deg) translateX(350px) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg) translateX(350px) rotate(-360deg);
            }
        }

        @keyframes orbit2 {
            0% {
                transform: translate(-50%, -50%) rotate(90deg) translateX(350px) rotate(-90deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(450deg) translateX(350px) rotate(-450deg);
            }
        }

        @keyframes orbit3 {
            0% {
                transform: translate(-50%, -50%) rotate(180deg) translateX(350px) rotate(-180deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(540deg) translateX(350px) rotate(-540deg);
            }
        }

        @keyframes orbit4 {
            0% {
                transform: translate(-50%, -50%) rotate(270deg) translateX(350px) rotate(-270deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(630deg) translateX(350px) rotate(-630deg);
            }
        }

        @media (max-width: 900px) {
            .orbit-pattern {
                width: 80px;
                height: 80px;
            }

            .orbit1,
            .orbit2,
            .orbit3,
            .orbit4 {
                animation-duration: 16s;
            }

            @keyframes orbit1 {
                0% {
                    transform: translate(-50%, -50%) rotate(0deg) translateX(180px) rotate(0deg);
                }

                100% {
                    transform: translate(-50%, -50%) rotate(360deg) translateX(180px) rotate(-360deg);
                }
            }

            @keyframes orbit2 {
                0% {
                    transform: translate(-50%, -50%) rotate(90deg) translateX(180px) rotate(-90deg);
                }

                100% {
                    transform: translate(-50%, -50%) rotate(450deg) translateX(180px) rotate(-450deg);
                }
            }

            @keyframes orbit3 {
                0% {
                    transform: translate(-50%, -50%) rotate(180deg) translateX(180px) rotate(-180deg);
                }

                100% {
                    transform: translate(-50%, -50%) rotate(540deg) translateX(180px) rotate(-540deg);
                }
            }

            @keyframes orbit4 {
                0% {
                    transform: translate(-50%, -50%) rotate(270deg) translateX(180px) rotate(-270deg);
                }

                100% {
                    transform: translate(-50%, -50%) rotate(630deg) translateX(180px) rotate(-630deg);
                }
            }

            .orbit-bg-container {
                min-width: 100vw;
                min-height: 100vh;
            }
        }

        .glass-bg {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1.5px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
        }
    </style>
    <div class="w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row overflow-hidden relative z-10 glass-bg">
        <!-- Left: Login Form -->
        <div class="w-full md:w-1/2 p-6 sm:p-8 flex flex-col justify-center">
            <div class="flex flex-col items-center mb-8">
                <img src="/assets/images/logo/cleanesta-logo.png" alt="Logo" class="h-14 sm:h-16 w-auto mb-2">
                <h1 class="text-xl sm:text-2xl font-bold text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">Admin Login</h1>
                <p class="text-gray-600 mt-2 text-center text-sm sm:text-base">Enter your credentials to access the admin panel</p>
            </div>
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center text-sm">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form method="post" class="space-y-5 sm:space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-sm sm:text-base"
                           placeholder="Enter your email">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:border-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] pr-12 text-sm sm:text-base"
                           placeholder="Enter your password">
                        <button type="button" id="togglePassword" tabindex="-1" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] focus:outline-none">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" 
                    class="w-full bg-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>] text-white py-2 px-4 rounded-lg hover:bg-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] transition duration-200 font-semibold text-base sm:text-lg shadow">
                    Login
                </button>
            </form>
        </div>
        <!-- Right: Image -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-gradient-to-br from-[<?php echo $themeColors['secondary'] ?? '#00bda4'; ?>] to-[<?php echo $themeColors['primary'] ?? '#f34d26'; ?>]">
            <img src="/assets/images/about/team.png" alt="Team" class="max-w-xs w-full rounded-xl shadow-xl m-6 sm:m-8 border-4 border-white">
        </div>
    </div>
    <script>
        // Eye toggle for password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        let passwordVisible = false;
        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function() {
                passwordVisible = !passwordVisible;
                passwordInput.type = passwordVisible ? 'text' : 'password';
                eyeIcon.innerHTML = passwordVisible ?
                    `<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.292m1.528-1.528A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.132M15 12a3 3 0 11-6 0 3 3 0 016 0z\" />\n<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 3l18 18\" />` :
                    `<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\" />\n<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\" />`;
            });
        }
    </script>
</body>

</html>