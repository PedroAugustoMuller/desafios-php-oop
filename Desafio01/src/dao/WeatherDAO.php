<?php

namespace Imply\Desafio01\dao;

use DB\MySQL;
use model\Weather;

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