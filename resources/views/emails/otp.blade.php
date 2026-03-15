<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Código OTP</title>
<style>
body{
    font-family: Arial, sans-serif;
    background:#f4f6f9;
    padding:30px;
}
.card{
    max-width:600px;
    background:white;
    margin:auto;
    border-radius:10px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    text-align:center;
}
.title{
    font-size:24px;
    font-weight:bold;
    color:#2c3e50;
}
.message{
    margin-top:20px;
    font-size:16px;
}
.otp{
    margin-top:25px;
    font-size:32px;
    font-weight:bold;
    letter-spacing:6px;
    color:#3498db;
    background:#f1f4f8;
    padding:15px;
    border-radius:8px;
    display:inline-block;
}
.footer{
    margin-top:30px;
    font-size:13px;
    color:#7f8c8d;
}
</style>
</head>

<body>

<div class="card">

<div class="title">
Verificación de seguridad
</div>

<div class="message">
Usa el siguiente código para completar tu inicio de sesión.
</div>

<div class="otp">
{{ $otp }}
</div>

<div class="footer">
Este código expirará en 5 minutos.
</div>

</div>

</body>
</html>