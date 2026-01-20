<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LearnEase</title>

    <!-- Font Awesome for toggle password icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 430px; margin: 40px auto; background: white; padding: 35px 28px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); box-sizing: border-box; }
        .logo-area { text-align: center; margin-bottom: 25px; }
        .logo-area img { width: 70px; height: auto; }
        h2 { text-align: center; margin-top: 10px; margin-bottom: 30px; font-size: 22px; font-weight: bold; color: #333; }
        label { font-weight: 600; font-size: 14px; color: #444; margin-bottom: 6px; display: block; }
        .input-box { position: relative; margin-bottom: 20px; width: 100%; }
        input, select { width: 100%; padding: 12px 14px; padding-right: 45px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; }
        input:focus, select:focus { border-color: #ffb100; box-shadow: 0 0 5px rgba(255,177,0,0.3); }
        .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px; color: #777; user-select: none; }
        .btn { width: 100%; background: #ffb100; border: none; padding: 12px; border-radius: 8px; color: white; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; }
        .btn:hover { background: #e59e00; }
        .signup-text { text-align: center; margin-top: 15px; font-size: 14px; }
        .signup-text a { color: #ffb100; font-weight: bold; text-decoration: none; }
        .error-box { background: #ffe5e5; padding: 10px; border: 1px solid #ff7373; color: #b10000; border-radius: 6px; margin-bottom: 20px; }
        .status-box { background: #e5ffe5; padding: 10px; border: 1px solid #73ff73; color: #007500; border-radius: 6px; margin-bottom: 20px; }
    </style>
</head>

<body>

<div class="container">

    <div class="logo-area">
        <img src="/img/logo.jpg" alt="LearnEase Logo">
    </div>

    <h2>LearnEase</h2>

    <!-- Show registration success message -->
    @if (session('success'))
        <div class="status-box">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="error-box">
            <ul style="padding-left: 18px; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <label>Email</label>
        <div class="input-box">
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@gmail.com">
        </div>

        <!-- Role -->
        <label>Role</label>
        <div class="input-box">
            <select name="role" required>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
            </select>
        </div>

        <!-- Password -->
        <label>Password</label>
        <div class="input-box">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">
                <i class="fa-solid fa-eye"></i>
            </span>
        </div>

        <!-- Remember Me + Forgot Password -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; font-size: 14px;">
            <label style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" id="remember" style="margin-right: 6px;">
                Remember Me
            </label>
            <a href="{{ route('password.request') }}" style="color: #ffb100; font-weight: bold; text-decoration: none;">Forgot Password?</a>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn">Login</button>

        <p class="signup-text">
            Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>

    </form>

</div>

<script>
    function togglePassword(id, icon) {
        const input = document.getElementById(id);
        const iconElem = icon.querySelector("i");

        if (input.type === "password") {
            input.type = "text";
            iconElem.classList.remove("fa-eye");
            iconElem.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            iconElem.classList.remove("fa-eye-slash");
            iconElem.classList.add("fa-eye");
        }
    }
</script>

</body>
</html>
