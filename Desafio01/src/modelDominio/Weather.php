<?php

namespace Imply\Desafio01\modelDominio;

class Weather{

    private string $cityName;
    private string $description;
    private string $icon;
    private float $temp;
    private float $feelsLike;
    private float $windSpeed;
    private int $humidity;
    private int $unixTime;
    

    public function __construct(string $cityName, string $description, string $icon, float $temp, float $feelsLike, float $windSpeed, int $humidity, int $unixTime)
    {
        $this->cityName = $cityName;
        $this->description = $description;
        $this->icon = $icon;
        $this->temp = $temp;
        $this->feelsLike = $feelsLike;
        $this->windSpeed = $windSpeed;
        $this->humidity = $humidity;
        $this->unixTime = $unixTime;
        
    }
    
    /**
     * getCityName
     *
     * @return string
     */
    public function getCityName() : string
    {
        return $this->cityName;
    }
    
    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }    
    /**
     * getIcon
     *
     * @return string
     */
    public function getIcon() : string
    {
        return $this->icon;
    }    
    /**
     * getTemp
     *
     * @return float
     */
    public function getTemp() : float
    {
        return $this->temp;
    }    
    /**
     * getFeelsLike
     *
     * @return float
     */
    public function getFeelsLike() : float
    {
        return $this->feelsLike;
    }    
    /**
     * getWindSpeed
     *
     * @return float
     */
    public function getWindSpeed() : float
    {
        return $this->windSpeed;
    }    
    /**
     * getHumidity
     *
     * @return int
     */
    public function getHumidity() : int
    {
        return $this->humidity;
    }    
    /**
     * getUnixTime
     *
     * @return int
     */
    public function getUnixTime() : int
    {
        return $this->unixTime;
    }

    public function getStringTime(): string
    {
        return gmdate("d/m/Y", $this->unixTime);
    }
}