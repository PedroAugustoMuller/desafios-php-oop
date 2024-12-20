<?php

namespace Imply\Desafio01\service;

use Exception;
use Imply\Desafio01\model\Weather;
use InvalidArgumentException;

class WeatherAPI
{
    private static $key = '8ea5bf57527bbe0b0f7c9d7f9488d0c8';
    private static $parameters = '&lang=pt_br&units=metric';
    /**
     * getWeather
     *
     * @param  string $cityName
     * @return object
     */
    public function getWeatherFromApi(string $cityName): object
    {
        try {

            $weatherData = $this->getWeatherData($cityName);
            if (!property_exists($weatherData, 'weather')) {
                throw new InvalidArgumentException("Cidade não encontrada");
            }
            return $this->createWeatherObject($weatherData);
        } catch (InvalidArgumentException $e) {
            return $e;
        }
    }
    /**
     * getWeatherDataFromApi
     *
     * @param  string $cityName
     * @return object
     */
    private function getWeatherData(string $cityName): object
    {
        $cityName = str_replace(" ", '%20', $cityName);
        $weatherData = null;
        try {

            $apiResponse =  "https://api.openweathermap.org/data/2.5/weather?q=" . $cityName . "&appid=" . self::$key . self::$parameters;
            $curl = curl_init($apiResponse);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $weatherData = json_decode(curl_exec($curl));
            unset($curl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $weatherData;
    }
    /**
     * createWeatherObject
     *
     * @param  mixed $weatherData
     * @return object
     */
    private function createWeatherObject(object $weatherData): object
    {
        $cityInfo = $weatherData->name . ', ' . $weatherData->sys->country;
        $description = $weatherData->weather[0]->description;
        $icon = $weatherData->weather[0]->icon;
        $temperature = $weatherData->main->temp;
        $feelsLike = $weatherData->main->feels_like;
        $windSpeed = $weatherData->wind->speed;
        $humidity = $weatherData->main->humidity;
        $unixTime = $weatherData->dt;
        return $weather = new Weather($cityInfo, $description, $icon, $temperature, $feelsLike, $windSpeed, $humidity, $unixTime);
    }
}
