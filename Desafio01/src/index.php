<?php

require '../vendor/autoload.php';

use Imply\Desafio01\controller\Controller;

$weather = null;
if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['city'] != "")
{
    $city = $_POST['city'];
    $controller = new Controller();
    $weather = $controller->getCityWeather($city);
    var_dump($weather);
} 



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="./public/js/script.js"></script>
    <link rel="stylesheet" href="./public/css/index.css">
    <title>Previsão do tempo</title>
</head>
<body>
    <div class="container">
        <h1 class="title">Previsão do Tempo</h1>
        <form class='inputs' action="" method="post">
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
                <input type="submit" class="search-btn" value="Procurar">
            </div>
            
        </form>
        <?php if( is_object($weather) && $weather != null) : ?>
        <div class="weather-info">
            <p class="location"><?php echo $weather->getCityInfo()?></p>
            <p class="temperature"><?php echo $weather->getTemp()?>°C</p>
            <p class="details">Data: <?php echo $weather->getStringTime()?></p>
            <p class="details">Descrição: <?php echo $weather->getDescription()?></p>
            <p class="details">Umidade: <?php echo $weather->getHumidity()?>%</p>
            <p class="details">Vento: <?php echo $weather->getWindSpeed()?>km/h</p>
            <p class="details">Sensação Térmica: <?php echo $weather->getFeelsLike()?>°C</p>
        </div>
        <?php endif;?>
    </div>
</body>
</html>