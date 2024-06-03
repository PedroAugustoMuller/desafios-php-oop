<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/index.css">
    <script type="text/javascript" src="Scripts/script.js"></script>
    <title>Previsão do tempo</title>
</head>
<body>
    <div class="container">
        <h1>Previsão do Tempo</h1>
        <form class='inputs' action="" method="get">
            <div class="cityDiv">
                <label for="city">Cidade</label>
                <input type="text" name="city" id="city">
            </div>
            <div class="sendEmailDiv"> 
                <label for="sendEmailCheckBox">Enviar para Email</label>
                <input type="checkbox" name="sendEmailCheckBox" id="sendEmailCheckBox" onclick="changeEmailDivState()" autocomplete="off">
                <div class="emailDiv" id='emailDiv'>
                    <label for="emailText">Email</label>
                    <input type="text" name="emailText" id="emailText">
                </div>
            </div>
            <div class="searchDiv">
                <button type="button" class="search-btn">Procurar</button>
            </div>
            
        </form>
        <div class="weather-info">
            <div class="location">São Paulo, Brasil</div>
            <div class="temperature">25°C</div>
            <div class="details">Descrição: Ensolarado</div>
            <div class="details">Umidade: 30%</div>
            <div class="details">Vento: 5km/h</div>
            <div class="details">Sensação Térmica: 29°</div>
        </div>
    </div>
</body>
</html>
