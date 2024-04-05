<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmació Compra</title>
</head>
<body>
    <h2>Gràcies per la teva compra!</h2>
    <p>La teva compra ha estat confirmada correctament.</p>

    <p>Detalls de la compra:</p>
    <ul>
        <li>Pel·lícula: {{ $data['movie_id'] }}</li>
        <li>Preu Total: {{ $data['preu'] }}€</li>
        <li>Fila: {{ $data['fila']}} Columna: {{ $data['columna']}}</li>
    </ul>

    <p>Si tens alguna pregunta o necessites assistència, no dubtis en contactar-nos.</p>
    
    <p>Salutacions,</p>
    <p>El teu equip de Cineliaco</p>
</body>
</html>
