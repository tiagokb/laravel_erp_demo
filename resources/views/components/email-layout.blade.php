<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }

        .header {
            background-color: rgb(22 163 74);
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
            color: #333333;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: rgb(22 163 74);
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            font-size: 12px;
            color: #999999;
            text-align: center;
            padding: 20px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{config('app.name', 'laravel')}}</h1>
    </div>

    <div class="content">
        {{ $slot }}

        <p style="margin-bottom: 24px;">
            Para acompanhar o status do seu pedido ou obter mais informações, acesse o site pelo link abaixo:
        </p>
        <a href="{{ config('app.url') . '/orders' }}"
           style="display: inline-block; padding: 12px 24px; background-color:  rgb(22 163 74); color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold;">
            Acompanhar Pedido
        </a>

        <p style="margin-top: 32px; font-size: 14px; color: #666;">
            Se tiver qualquer dúvida, estamos à disposição para ajudar.
        </p>

        <p style="margin-top: 8px;">Atenciosamente,<br><strong>{{ config('app.name') }}</strong></p>
    </div>

    <div class="footer">
        <p>Você está recebendo este e-mail porque realizou uma compra em nosso site.</p>
        <p>&copy; {{ date('Y') }} {{config('app.name', 'laravel')}}. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>
