<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Apuesta Confirmada</title>
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
}
.header{
    text-align:center;
    margin-bottom:25px;
}
.title{
    color:#2c3e50;
    font-size:24px;
    font-weight:bold;
}
.success{
    color:#27ae60;
    font-size:20px;
    margin-top:10px;
}
.data{
    background:#f8f9fb;
    padding:20px;
    border-radius:8px;
    margin-top:20px;
}
.data p{
    margin:8px 0;
    font-size:15px;
}
.footer{
    text-align:center;
    margin-top:30px;
    font-size:13px;
    color:#7f8c8d;
}
</style>
</head>

<body>

<div class="card">

<div class="header">
<div class="title">Sistema de Apuestas</div>
<div class="success">Tu apuesta fue registrada correctamente</div>
</div>

<div class="data">

<p><strong>Evento:</strong> {{ $apuesta->evento->equipo_local }} vs {{ $apuesta->evento->equipo_visitante }}</p>

<p><strong>Tipo de apuesta:</strong> {{ $apuesta->tipo_apuesta }}</p>

<p><strong>Monto apostado:</strong> ${{ $apuesta->monto }}</p>

<p><strong>Cuota:</strong> {{ $apuesta->cuota }}</p>

<p><strong>Ganancia potencial:</strong> ${{ $apuesta->ganancia }}</p>

</div>

<div class="footer">
Gracias por usar nuestra plataforma de apuestas deportivas.
</div>

</div>

</body>
</html>