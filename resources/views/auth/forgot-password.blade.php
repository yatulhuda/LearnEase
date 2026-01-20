<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LearnEase</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f8f9fa; 
            margin: 0; 
            padding: 0; 
        }

        .container { 
            width: 100%; 
            max-width: 430px; 
            margin: 40px auto; 
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
        }

        input, .btn {
            width: 100%;
            box-sizing: border-box;
            border-radius: 8px;
            font-size: 15px;
        }

        input {
            padding: 12px 14px;
            border: 1px solid #ccc;
            outline: none;
        }

        input:focus {
            border-color: #ffb100;
            box-shadow: 0 0 5px rgba(255,177,0,0.3);
        }

        .btn { 
            padding: 12px 14px; 
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

    <h2>Forgot Password</h2>

    @if ($errors->any())
        <div class="error-box">
            <ul style="padding-left: 18px; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-box">
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
        </div>
        <button type="submit" class="btn">Verify Email</button>
    </form>

    <p style="text-align:center; margin-top: 15px;">
        <a href="{{ route('login') }}" style="color:#ffb100; font-weight:bold; text-decoration:none;">Back to Login</a>
    </p>
</div>

</body>
</html>
