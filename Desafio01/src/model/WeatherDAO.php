<?php

namespace Imply\Desafio01\model;

use Exception;
use Imply\Desafio01\DB\MySQL;
use Imply\Desafio01\modelDominio\Weather;
use InvalidArgumentException;
use PDOException;

class WeatherDAO{
    private object $MySQL;

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }
    
    /**
     * insertWeatherIntoDb
     *
     * @param  Weather $weather
     * @return int
     */
    public function insertWeatherIntoDb(Weather $weather) : int
    {
        try
        {
            $stmt = 'INSERT INTO weather (city_info,description,icon,temp,feels_like,wind_speed,humidity,unixTime) VALUES (
            :city_info,
            :description,
            :icon,
            :temp,
            :feels_like,
            :wind_speed,
            :humidity,
            :unixTime);';
            $this->MySQL->getDb()->beginTransaction();
            $preparedStmt = $this->MySQL->getDb()->prepare($stmt);
            $cityInfo = $weather->getCityInfo();
            $description = $weather->getDescription();
            $icon = $weather->getIcon();
            $temp = $weather->getTemp();
            $feelsLike = $weather->getFeelsLike();
            $windSpeed = $weather->getWindSpeed();
            $humidity = $weather->getHumidity();
            $unixTime = $weather->getUnixTime();
            $preparedStmt->bindparam(':city_info',$cityInfo);
            $preparedStmt->bindParam(':description',$description);
            $preparedStmt->bindParam(':icon',$icon);
            $preparedStmt->bindParam(':temp',$temp);
            $preparedStmt->bindparam(':feels_like',$feelsLike);
            $preparedStmt->bindparam(':wind_speed',$windSpeed);
            $preparedStmt->bindparam(':humidity',$humidity);
            $preparedStmt->bindparam(':unixTime',$unixTime);
            $preparedStmt->execute();
            if($preparedStmt->rowCount() == 1)
            {
                $this->MySQL->getDb()->commit();
                return $preparedStmt->rowCount();
            }
        }catch(PDOException $PdoException)
        {
            throw new InvalidArgumentException($PdoException->getMessage());
        }catch(Exception $Exc)
        {
            throw new InvalidArgumentException($Exc->getMessage());
        }
        $this->MySQL->getDb()->rollBack();
        return 0;
    }

    public function getWeatherFromDb(string $cityName)
    {
        try
        {
            $currentUnixTime = time() - (60*60);
            $insert = 'SELECT city_info,description,icon,temp,feels_like,wind_speed,humidity,unixTime FROM weather 
            WHERE city_info LIKE :city_info AND unixTime < :current_unix_time;';
            $stmt = $this->MySQL->getDb()->prepare($insert);
            $cityNameForQuery = $cityName . '%';
            $stmt->bindparam(':city_info',$cityNameForQuery);
            $stmt->bindparam(':current_unix_time', $currentUnixTime);
            $stmt->execute();
            $weatherData = $stmt->fetchAll();
            return $this->createWeatherObject($weatherData);
        }catch(PDOException $PdoException)
        {
            echo $PdoException->getMessage();
        }catch(Exception $Exc)
        {
            echo $Exc->getMessage();
        }
        return 0; 
    }

    public function createWeatherObject(array $weatherData)
    {
        // $cityInfo = $weatherData->name.', '. $weatherData->sys->country;
        // //Description
        // $description = $weatherData->weather[0]->description;
        // //ICON
        // $icon = $weatherData->weather[0]->icon;
        // //TEMPERATURE
        // $temperature = $weatherData->main->temp;
        // //WHAT TEMP FEELS LIKE
        // $feelsLike = $weatherData->main->feels_like;
        // //WINDSPEED
        // $windSpeed = $weatherData->wind->speed;
        // //HUMIDITY
        // $humidity = $weatherData->main->humidity;
        // //UNIX
        // $unixTime = $weatherData->dt;
        // return $weather = new Weather($cityInfo,$description,$icon,$temperature,$feelsLike,$windSpeed,$humidity,$unixTime);
    }
}