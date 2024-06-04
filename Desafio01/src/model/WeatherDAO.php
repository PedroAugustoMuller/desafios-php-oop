<?php

namespace Imply\Desafio01\model;
use Imply\Desafio01\DB\MySQL;




class WeatherDAO{
    private object $MySQL;

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertWeatherIntoDb()
    {

    }

    public function getWeatherFromDb(string $cityName)
    {
        // SELECT * FROM weather WHERE city_name = :cityName;
    }
}