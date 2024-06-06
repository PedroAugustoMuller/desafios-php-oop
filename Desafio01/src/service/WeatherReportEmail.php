<?php

namespace Imply\Desafio01\service;

use Imply\Desafio01\model\Weather;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class WeatherReportEmail{
    function sendEmail(Weather $weather, string $targetEmail)
    {
        $transport = Transport::fromDsn('smtp://pedro.muller.a@gmail.com:xkrzxbcpmlufwnke@smtp.gmail.com:587');
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('hello@example.com')
            ->to($targetEmail)
            ->subject("Clima". $weather->getCityInfo()." - " . $weather->getStringTime())
            ->text('')
            ->html("<p class='location'><Cidade: ".$weather->getCityInfo()."</p>
            <img src='https://openweathermap.org/img/wn/".$weather->getIcon()."@2x.png. 'alt=''>
            <p class='temperature'>Temperatura: ". $weather->getTemp()."°C</p>
            <p class='details'>Data: ".  $weather->getStringTime()."</p>
            <p class='details'>Descrição: ". $weather->getDescription()."</p>
            <p class='details'>Umidade: ". $weather->getHumidity()."%</p>
            <p class='details'>Vento: ". $weather->getWindSpeed()."km/h</p>
            <p class='details'>Sensação Térmica: ". $weather->getFeelsLike()."°C</p>");

        $mailer->send($email);
    }
}