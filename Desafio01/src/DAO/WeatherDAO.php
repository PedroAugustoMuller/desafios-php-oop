<?php

namespace Imply\Desafio01\DAO;

use Exception;
use Imply\Desafio01\DB\MySQL;
use Imply\Desafio01\model\Weather;
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
        $error = null;
        try
        {
            $insert = 'SELECT city_info,description,icon,temp,feels_like,wind_speed,humidity,unixTime FROM weather 
            WHERE city_info LIKE :city_info AND UNIX_TIMESTAMP() - unixTime < 3600 ORDER BY id DESC LIMIT 1';
            $stmt = $this->MySQL->getDb()->prepare($insert);
            $cityNameForQuery = $cityName . '%';
            $stmt->bindparam(':city_info',$cityNameForQuery);
            $stmt->execute();
            $weatherData = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
            if(empty($weatherData))
            {
                throw new Exception("Nenhum dado retornado");
            }
            $weather = $this->createWeatherObjectFromDb($weatherData);
            return $weather;
        }catch(PDOException $PdoException)
        {
            $error = $PdoException;
        }
        catch(InvalidArgumentException $invalidExp)
        {
            $error = $invalidExp;
        }
        catch(Exception $Exc)
        {
            $error = $Exc;
        }
        return $error; 
    }

    public function createWeatherObjectFromDb(array $weatherData)
    {
        if($weatherData == null)
        {
            return null;
        }
        $cityInfo = $weatherData[0]['city_info'];
        // Description
        $description = $weatherData[0]['description'];
        // //ICON
        $icon = $weatherData[0]['icon'];
        // //TEMPERATURE
        $temperature = $weatherData[0]['temp'];
        // //WHAT TEMP FEELS LIKE
        $feelsLike = $weatherData[0]['feels_like'];
        // //WINDSPEED
        $windSpeed = $weatherData[0]['wind_speed'];
        // //HUMIDITY
        $humidity = $weatherData[0]['humidity'];
        // //UNIX
        $unixTime = $weatherData[0]['unixTime'];
        $weather = new Weather($cityInfo,$description,$icon,$temperature,$feelsLike,$windSpeed,$humidity,$unixTime);
        return $weather;
    }
}