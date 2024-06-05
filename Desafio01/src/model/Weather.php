<?php

namespace Imply\Desafio01\model;

class Weather{

    private string $cityInfo;
    private string $description;
    private string $icon;
    private float $temp;
    private float $feelsLike;
    private float $windSpeed;
    private int $humidity;
    private int $unixTime;
    
    
    /**
     * __construct
     *
     * @param  string $cityInfo
     * @param  string $description
     * @param  string $icon
     * @param  float $temp
     * @param  float $feelsLike
     * @param  float $windSpeed
     * @param  int $humidity
     * @param  int $unixTime
     * @return void
     */
    public function __construct(string $cityInfo, string $description, string $icon, float $temp, float $feelsLike, float $windSpeed, int $humidity, int $unixTime)
    {
        $this->cityInfo = $cityInfo;
        $this->description = $description;
        $this->icon = $icon;
        $this->temp = $temp;
        $this->feelsLike = $feelsLike;
        $this->windSpeed = $windSpeed;
        $this->humidity = $humidity;
        $this->unixTime = $unixTime;
        
    }
    
    /**
     * getcityInfo
     *
     * @return string
     */
    public function getCityInfo() : string
    {
        return $this->cityInfo;
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
    
    /**
     * getStringTime
     *
     * @return string
     */
    public function getStringTime(): string
    {
        return date('d/m/Y',$this->unixTime);
    }
}