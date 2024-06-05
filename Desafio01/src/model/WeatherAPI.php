<?php

namespace Imply\Desafio01\model;

use Exception;
use Imply\Desafio01\modelDominio\Weather;


class WeatherAPI{    
    /**
     * getWeather
     *
     * @param  string $cityName
     * @return object
     */
    public function getWeather(string $cityName) : object
    {   
        $weatherData = $this->getWeatherDataFromApi($cityName);
        //NAME
        $cityInfo = $weatherData->name.', '. $weatherData->sys->country;
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
        return $weather = new Weather($cityInfo,$description,$icon,$temperature,$feelsLike,$windSpeed,$humidity,$unixTime);
    }    
    /**
     * getWeatherDataFromApi
     *
     * @param  string $cityName
     * @return object
     */
    private function getWeatherDataFromApi(string $cityName) : object
    {
        $cityName = str_replace(" ",'%20',$cityName);
        $weatherData = null;
        try
        {
            $key = '8ea5bf57527bbe0b0f7c9d7f9488d0c8';
            $apiResponse =  "https://api.openweathermap.org/data/2.5/weather?q=$cityName&appid=$key&lang=pt_br&units=metric";
            $weatherData = json_decode(file_get_contents($apiResponse));
        }catch(Exception $e)
        {
            echo $e->getMessage();
        }
        return $weatherData;
        
    }
}