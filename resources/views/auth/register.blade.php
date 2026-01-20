<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LearnEase</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 430px; margin: 40px auto; background: white; padding: 35px 28px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); box-sizing: border-box; }
        .logo-area { text-align: center; margin-bottom: 25px; }
        .logo-area img { width: 70px; height: auto; }
        h2 { text-align: center; margin-top: 10px; margin-bottom: 10px; font-size: 22px; font-weight: bold; color: #333; }
        h3 { text-align: center; margin-top: 0; margin-bottom: 30px; font-size: 18px; font-weight: bold; color: #333; }
        label { font-weight: 600; font-size: 14px; color: #444; margin-bottom: 6px; display: block; }
        .input-box { position: relative; margin-bottom: 20px; width: 100%; }
        input, select { width: 100%; padding: 12px 14px; padding-right: 45px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; outline: none; box-sizing: border-box; transition: border-color 0.3s ease; }
        input:focus, select:focus { border-color: #ffb100; box-shadow: 0 0 5px rgba(255,177,0,0.3); }
        .toggle-password { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px; color: #777; }
        .btn { width: 100%; background: #ffb100; border: none; padding: 12px; border-radius: 8px; color: white; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; }
        .btn:hover { background: #e59e00; }
        .login-text { text-align: center; margin-top: 15px; font-size: 14px; }
        .login-text a { color: #ffb100; font-weight: bold; text-decoration: none; }
        .error-box { background: #ffe5e5; padding: 10px; border: 1px solid #ff7373; color: #b10000; border-radius: 6px; margin-bottom: 20px; }
    </style>

</head>
<body>

<div class="container">

    <div class="logo-area">
        <img src="/img/logo.jpg" alt="LearnEase Logo">
    </div>

    <h2>LearnEase</h2>
    <h3>Create Your Account</h3>

    @if ($errors->any())
        <div class="error-box">
            <ul style="padding-left: 18px; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <label>Full Name</label>
        <div class="input-box">
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <!-- Email -->
        <label>Email</label>
        <div class="input-box">
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@gmail.com">
        </div>

        <!-- Phone Number -->
        <label>
            Phone Number <span style="font-weight: normal; color: #777;">(Optional)</span>
        </label>
        <div class="input-box">
            <input 
                type="text" 
                name="phone_number" 
                value="{{ old('phone_number') }}" 
                placeholder="e.g. 0123456789">
        </div>
        <small style="color: #777; font-size: 12px; display: block; margin-top: -12px; margin-bottom: 18px;">
            You may leave this field empty.
        </small>

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

        <!-- Confirm Password -->
        <label>Confirm Password</label>
        <div class="input-box">
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                <i class="fa-solid fa-eye"></i>
            </span>
        </div>

        <!-- Register Button -->
        <button type="submit" class="btn">Register</button>

        <p class="login-text">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
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
