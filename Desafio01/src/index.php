<?php

require '../vendor/autoload.php';

use Imply\Desafio01\controller\Controller;

$weather = null;
if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['city'] != "")
{
    $city = $_POST['city'];
    $controller = new Controller();
    $weather = $controller->getCityWeather($city);
    if(isset($_POST['sendEmailCheckBox']))
    {
        if($_POST['emailText'] == ""){
            return;
        }
        $targetEmail = $_POST['emailText'];
        $controller->sendEmail($weather,$targetEmail);
    }
} 



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../public/js/script.js"></script>
    <link rel="stylesheet" href="../public/css/index.css">
    <title>Previsão do tempo</title>
</head>
<body>
    <div class="container">
        <div class="head">
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
                    <input type="email" name="emailText" id="emailText">
                </div>
            </div>
            <div class="searchDiv">
                <input type="submit" class="search-btn" id="searchBtn" value="Procurar" onclick="checkIfEmailEmpty()">
            </div>
            
        </form>
        </div>
        <?php if($weather instanceof Exception) : ?>
            <p class="temperature">Cidade não encontrada</p>
            <script>alertCityNotFound()</script>
        <?php endif;?>   
        <?php if( is_object($weather) && ! $weather instanceof Exception) : ?>
        <div class="weather-info">
            <p class="location"><?php echo $weather->getCityInfo()?></p>
            <img src=<?php echo "https://openweathermap.org/img/wn/".$weather->getIcon()."@2x.png"?> alt="">
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