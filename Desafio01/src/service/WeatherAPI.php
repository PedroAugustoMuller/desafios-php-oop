<?php

namespace Imply\Desafio01\service;

use Exception;
use Imply\Desafio01\model\Weather;
use InvalidArgumentException;

class WeatherAPI{   
    private static $key = '8ea5bf57527bbe0b0f7c9d7f9488d0c8';
    private static $parameters = '&lang=pt_br&units=metric';
    /**
     * getWeather
     *
     * @param  string $cityName
     * @return object
     */
    public function getWeatherFromApi(string $cityName) : object
    {   
        $weatherData = $this->getWeatherData($cityName);
        return $this->createWeatherObject($weatherData);
    }    
    /**
     * getWeatherDataFromApi
     *
     * @param  string $cityName
     * @return object
     */
    private function getWeatherData(string $cityName) : object
    {
        $cityName = str_replace(" ",'%20',$cityName);
        $weatherData = null;
        try
        {
            
            $apiResponse =  "https://api.openweathermap.org/data/2.5/weather?q=". $cityName. "&appid=". self::$key . self::$parameters;
            $curl = curl_init($apiResponse);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            $weatherData = json_decode(curl_exec($curl));
            unset($curl);
        }catch(Exception $e)
        {
            echo $e->getMessage();
        }
        return $weatherData;
        
    }
    private function createWeatherObject(object $weatherData)
    {
        try
        {
            if(is_null($weatherData))
        {
            throw new Exception("Cidade não válida");
        }
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
        catch(Exception $e)
        {
            $e->getMessage();
        }
        
    }
}