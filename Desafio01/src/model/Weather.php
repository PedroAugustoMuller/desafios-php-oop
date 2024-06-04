<?php

namespace Imply\Desafio01\model;

class Weather{

    private string $cityName;
    private string $main;
    private string $icon;
    private float $temp;
    private float $feelsLike;
    private int $humidity;

    public function __construct(string $cityName, string $main, string $icon, float $temp, float $feelsLike, int $humidity)
    {
        $this->cityName = $cityName;
        $this->main = $main;
        $this->icon = $icon;
        $this->temp = $temp;
        $this->feelsLike = $feelsLike;
        $this->humidity = $humidity;
    }

    public static function getWeather(string $cityName)
    {   
        
        $weatherData = self::getWeatherDataFromApi($cityName);

        $cityName = $weatherData->name;
        $main = $weatherData->weather['main'];
        $icon = $weatherData->weather['icon'];
        $temp = $weatherData->main['temp'];
        $feelsLike = $weatherData->main['feels_like'];
        $humidity = $weatherData->main['humidity'];
        return $weather = new Weather($cityName,$main,$icon,$temp,$feelsLike,$humidity);
    }

    public static function getCoordinates(string $city):array{
        $city = str_replace(" ","",$city);
        $apiResponse = "https://maps.googleapis.com/maps/api/geocode/json?address=$city&key=AIzaSyBwrdxGDMVSGdmEDZrKUge8v4_xVbdsKlA";
        $Geocode = json_decode(file_get_contents($apiResponse));
        $coordinates['lat'] = $Geocode->results[0]->geometry->location->lat;
        $coordinates['lon'] = $Geocode->results[0]->geometry->location->lng;
    
        return $coordinates;
    }

    private static function getWeatherDataFromApi(string $cityName)
    {
        $apiResponse = "https://api.openweathermap.org/data/2.5/weather?q=$cityName&appid=e2c947183766eabde79b731c43263ff7&lang=pt_br&units=metric";
        $weatherData = json_decode(file_get_contents($apiResponse));
        return $weatherData;
    }

}