<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LearnEase</title>
    <!-- Font Awesome for eye icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f8f9fa; 
            margin: 0; 
            padding: 0; 
        }

        .container { 
            max-width: 430px; 
            margin: 50px auto; 
            background: white; 
            padding: 35px 40px 35px 28px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
            box-sizing: border-box; 
        }

        .logo-area { 
            text-align: center; 
            margin-bottom: 25px; 
        }

        .logo-area img { 
            width: 70px; 
            height: auto; 
        }

        h2 { 
            text-align: center; 
            margin-bottom: 30px; 
            color: #333; 
        }

        .input-box { 
            margin-bottom: 20px; 
            position: relative; 
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            box-sizing: border-box;
            font-size: 15px;
        }

        input:focus {
            border-color: #ffb100;
            box-shadow: 0 0 5px rgba(255,177,0,0.3);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #777;
        }

        .btn { 
            width: 100%; 
            padding: 12px 14px; 
            border-radius: 8px; 
            border: none; 
            background: #ffb100; 
            color: white; 
            font-weight: bold; 
            cursor: pointer; 
        }

        .btn:hover { 
            background: #e59e00; 
        }

        .error-box { 
            background: #ffe5e5; 
            padding: 10px; 
            border: 1px solid #ff7373; 
            color: #b10000; 
            border-radius: 6px; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>

<div class="container">
    <div class="logo-area">
        <img src="/img/logo.jpg" alt="LearnEase Logo">
    </div>

    <h2>Reset Password</h2>

    @if ($errors->any())
        <div class="error-box">
            <ul style="padding-left: 18px; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- New Password -->
        <div class="input-box">
            <input type="password" id="password" name="password" required placeholder="New Password">
            <span class="toggle-password" onclick="togglePassword('password', this)">
                <i class="fa-solid fa-eye"></i>
            </span>
        </div>

        <!-- Confirm New Password -->
        <div class="input-box">
            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm New Password">
            <span class="toggle-password" onclick="togglePassword('password_confirmation', this)">
                <i class="fa-solid fa-eye"></i>
            </span>
        </div>

        <button type="submit" class="btn">Reset Password</button>
    </form>

    <p style="text-align:center; margin-top: 15px;">
        <a href="{{ route('login') }}" style="color:#ffb100; font-weight:bold; text-decoration:none;">Back to Login</a>
    </p>
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
