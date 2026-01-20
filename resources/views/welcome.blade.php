<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LearnEase</title>
    <style>
        body {
            font-family: 'Comic Sans MS', Arial, sans-serif;
            background: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: #ffb100;
            padding: 40px 20px 60px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        header img {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
            text-shadow: 1px 1px 2px #00000033;
        }

        /* Playful math icons */
        .icon {
            position: absolute;
            font-size: 28px;
            color: rgba(255, 255, 255, 0.5);
            animation: float 6s infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(15deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .intro {
            flex: 1;
            max-width: 800px;
            margin: -50px auto 50px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            padding: 50px 30px;
            text-align: center;
        }

        .intro p {
            font-size: 18px;
            line-height: 1.7;
            color: #333;
        }

        .btn-get-started {
            display: inline-block;
            background: #ffb100;
            color: white;
            font-weight: bold;
            padding: 16px 36px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 18px;
            margin-top: 25px;
            transition: background 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }

        .btn-get-started:hover {
            background: #e59e00;
        }

        @media (max-width: 600px) {
            header h1 {
                font-size: 28px;
            }

            .intro {
                margin: -30px 20px 40px;
                padding: 30px 20px;
            }

            .intro p {
                font-size: 16px;
            }
        }
    </style>
    <!-- Font Awesome for math icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header>
    <img src="/img/logo.jpg" alt="LearnEase Logo">
    <h1>Welcome to LearnEase!</h1>

    <!-- Math icons floating -->
    <i class="fa-solid fa-square-plus icon" style="top:20px; left:30px; animation-delay: 0s;"></i>
    <i class="fa-solid fa-percent icon" style="top:50px; left:90px; animation-delay: 2s;"></i>
    <i class="fa-solid fa-divide icon" style="top:30px; right:40px; animation-delay: 1s;"></i>
    <i class="fa-solid fa-square-root-variable icon" style="top:80px; right:100px; animation-delay: 3s;"></i>
</header>

<div class="intro">
    <p>
        LearnEase is a web-based Learning Management System (LMS) designed specifically for Form 4 and Form 5 students to enhance their mathematics learning experience. 
        The platform provides an organized and secure environment where students can access quizzes, track their academic progress, and participate in discussion forums. 
        Teachers can efficiently manage courses, monitor student performance, and provide timely feedback. 
        LearnEase integrates essential educational tools into a single platform, ensuring an effective, structured, and interactive approach to learning mathematics.
    </p>
    <a href="{{ route('login') }}" class="btn-get-started">Get Started</a>
</div>

</body>
</html>
