<!DOCTYPE html>
<html>
<head>
    <title>Delete Discussion</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; padding: 25px; }
        .container {
            max-width: 600px; margin: auto; padding: 30px;
            background: #fff; border-radius: 10px; text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .btn-delete {
            background: red; color: #fff; padding: 10px 20px;
            border: none; border-radius: 6px; cursor: pointer;
        }
        .btn-cancel {
            margin-top: 15px; display: inline-block; text-decoration: none; color: #333;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Delete Discussion</h2>
    <p>Are you sure you want to delete this discussion?</p>

    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button class="btn-delete">Yes, Delete</button>
    </form>

    <a href="{{ route('discussion.index') }}" class="btn-cancel">Cancel</a>
</div>
</body>
</html>
