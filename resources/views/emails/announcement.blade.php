<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Announcement</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 620px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header h2 {
            color: #4f46e5;
            margin-bottom: 0;
        }
        .content {
            font-size: 16px;
            color: #333333;
            line-height: 1.6;
        }
        .timestamp {
            margin-top: 25px;
            font-size: 14px;
            color: #6b7280;
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📢 New Announcement</h2>
        </div>

        <div class="content">
            <p>{{ $announcement->announcement }}</p>
        </div>

        <div class="timestamp">
            <em>🕒 {{ \Carbon\Carbon::parse($announcement->created_at)->format('F j, Y \\a\\t g:i A') }}</em>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} School Management. All rights reserved.
        </div>
    </div>
</body>
</html>
