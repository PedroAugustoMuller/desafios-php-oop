<?php

function getCoordinates(string $city):array{
    $city = 'Sao Paulo';
    $city = str_replace(" ","",$city);
    $apiResponse = "https://maps.googleapis.com/maps/api/geocode/json?address=$city&key=AIzaSyBwrdxGDMVSGdmEDZrKUge8v4_xVbdsKlA";
    $Geocode = json_decode(file_get_contents($apiResponse));
    $coordinates['lat'] = $Geocode->results[0]->geometry->location->lat;
    $coordinates['lon'] = $Geocode->results[0]->geometry->location->lng;

    return $coordinates;
}