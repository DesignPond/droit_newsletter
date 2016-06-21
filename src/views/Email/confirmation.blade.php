<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: arial, sans-serif;">
    <h2 style="font-family: arial, sans-serif; color: #dd0330;font-size: 20px;font-weight: 300;letter-spacing: 0;line-height: 30px;">{{ url('/') }}</h2>
    <h3 style="font-family: arial, sans-serif;">Inscription à la newsletter</h3>
    <div style="font-family: arial, sans-serif;">Pour confirmer votre inscription sur {{ url('/') }} veuillez suivre ce lien:
        <p style="font-family: arial, sans-serif;">
            <a style="text-align:center;font-size:13px;font-family:arial,sans-serif;
                color:white;font-weight:bold;background-color: #1c1c84;border: 1px solid #1c1c84;
                text-decoration:none;display:inline-block;min-height:27px;padding-left:8px;padding-right:8px;
                line-height:27px;border-radius:2px;border-width:1px" href="{{ url('activation/'.$token) }}">Confirmer l'adresse email</a>
        </p>
    </div>
    <p><a style="font-family: arial, sans-serif;color: #444; font-size: 13px;" href="{{ url('/') }}">{{ url('/') }}</a></p>
</body>
</html>
