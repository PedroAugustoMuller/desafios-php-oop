<?php

namespace Imply\Desafio01\model;

use Exception;
use Imply\Desafio01\modelDominio\Weather;


class WeatherAPI{
    public function getWeather(string $cityName)
    {   

        $coordinates = $this->getCoordinates($cityName);
        
        $weatherData = $this->getWeatherDataFromApi($coordinates);
        //NAME
        $cityName = $weatherData->name;
        //Description
        $description = $weatherData->weather[0]->description;
        //ICON
        $icon = $weatherData->weather[0]->icon;
        //TEMPERATURE
        $temperature = $weatherData->main->temp;
        //WHAT TEMP FEELS LIKE
        $feelsLike = $weatherData->main->feels_like;
        //WINDSPEED
        $windSpeed = $weatherData->wind->speed;
        //HUMIDITY
        $humidity = $weatherData->main->humidity;
        //UNIX
        $unixTime = $weatherData->dt;
        return $weather = new Weather($cityName,$description,$icon,$temperature,$feelsLike,$windSpeed,$humidity,$unixTime);
    }

    private function getCoordinates(string $cityName) : array{
        $coordinates = [];
        try
        {
            $city = str_replace(" ","%20",$cityName);
            $apiResponse = "https://maps.googleapis.com/maps/api/geocode/json?address=$city&key=AIzaSyBwrdxGDMVSGdmEDZrKUge8v4_xVbdsKlA";
            $Geocode = json_decode(file_get_contents($apiResponse));
            $coordinates['lat'] = $Geocode->results[0]->geometry->location->lat;
            $coordinates['lng'] = $Geocode->results[0]->geometry->location->lng;
        }catch (Exception $e)
        {
            echo $e->getMessage();
        }
        
    
        return $coordinates;
    }

    private function getWeatherDataFromApi(array $coordinates) : object
    {
        $lat = $coordinates['lat'];
        $lng = $coordinates['lng'];
        $weatherData = null;
        try
        {
            $apiResponse = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lng&appid=e2c947183766eabde79b731c43263ff7&lang=pt_br&units=metric";
            $weatherData = json_decode(file_get_contents($apiResponse));
        }catch(Exception $e)
        {
            echo $e->getMessage();
        }
        return $weatherData;
        
    }
}