<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail cím megerősítése</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4fdf8;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            color: #333333;
        }
        .wrapper {
            width: 100%;
            background-color: #f4fdf8;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #10b981; 
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            color: #1f2937;
            font-size: 20px;
            margin-top: 0;
        }
        .content p {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 24px;
        }
        .button-container {
            text-align: center;
            margin: 35px 0;
        }
        .button {
            display: inline-block;
            background-color: #10b981;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #059669;
        }
        .fallback-link {
            font-size: 13px;
            color: #6b7280;
            margin-top: 30px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            word-break: break-all;
        }
        .fallback-link a {
            color: #10b981;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
        }
        
        @media only screen and (max-width: 600px) {
            .container { width: 90% !important; }
            .content { padding: 30px 20px !important; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <h1>Mentesch</h1>
            </div>

            <div class="content">
                <h2>Kedves {{ $user->username }}!</h2>
                
                <p>Nagyon örülünk, hogy csatlakoztál hozzánk! Már csak egyetlen apró lépés van hátra, hogy teljes körűen használhasd a fiókodat.</p>
                
                <p>Kérjük, kattints az alábbi gombra az e-mail címed megerősítéséhez:</p>

                <div class="button-container">
                    <a href="{{ $url }}" class="button">E-mail cím megerősítése</a>
                </div>

                <p>Üdvözlettel,<br>A Mentesch csapata</p>

                <div class="fallback-link">
                    Ha a fenti gomb nem működik, másold be a következő hivatkozást a böngésződ címsorába:<br>
                    <a href="{{ $url }}">{{ $url }}</a>
                </div>
            </div>

            <div class="footer">
                <p>Ezt az üzenetet azért kaptad, mert regisztráltál a mi oldalunkon. Ha nem te hoztad létre a fiókot, kérjük, hagyd figyelmen kívül ezt a levelet.</p>
                <p>&copy; {{ date('Y') }} Mentesch. Minden jog fenntartva.</p>
            </div>
        </div>
    </div>
</body>
</html>