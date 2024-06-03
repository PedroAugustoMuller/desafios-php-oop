<?php

function getWeatherData(float $lat, float $lon)
{
    $apiResponse = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=e2c947183766eabde79b731c43263ff7&units=metric";
    $weatherData = json_decode(file_get_contents($apiResponse));
    return $weatherData;
}