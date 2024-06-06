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
            ->subject("Clima em: ". $weather->getCityInfo()." - " . $weather->getStringTime())
            ->text('')
            // ->html("<p class='location'><Cidade: ".$weather->getCityInfo()."</p>
            //         <img src='https://openweathermap.org/img/wn/".$weather->getIcon()."@2x.png. 'alt=''>
            //         <p class='temperature'>Temperatura: ". $weather->getTemp()."°C</p>
            //         <p class='details'>Data: ".  $weather->getStringTime()."</p>
            //         <p class='details'>Descrição: ". $weather->getDescription()."</p>
            //         <p class='details'>Umidade: ". $weather->getHumidity()."%</p>
            //         <p class='details'>Vento: ". $weather->getWindSpeed()."km/h</p>
            //         <p class='details'>Sensação Térmica: ". $weather->getFeelsLike()."°C</p>");
            ->html("
                    <div style ='max-width: 800px;margin: 50px auto;background: #ffffff8b;padding: 20px;border-radius: 10px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);display: grid;justify-content: center;backdrop-filter: blur(5px);'>
                        <div style='text-align: center;'>
                            <p style='font-size: 36px;margin-bottom: 15px;color: black;font-weight: bold;'>" . $weather->getCityInfo() ."</p>
                        </div>
                        <div style='display: grid;grid-auto-flow: column;text-align: center;column-gap: 100px;'>
                            <div style ='display: grid;grid-auto-flow: column; column-gap: 10px;align-items: center;'>
                                <img src='https://openweathermap.org/img/wn/".$weather->getIcon()."@2x.png' alt=''>
                                <p style='font-size: 36px;font-weight: bold;color: #FFAE00;text-align: center;text-decoration: underline;'". $weather->getTemp(). "°C</p>
                            </div>
                            <div style='text-align: left;'>
                                <p styles='font-size: 24px;margin-bottom: 10px;'>📔Data: ". $weather->getStringTime()."</p>
                                <p styles='font-size: 24px;margin-bottom: 10px;'>⛅Descrição: " . $weather->getDescription() . "</p>
                                <p styles='font-size: 24px;margin-bottom: 10px;'>🌫️Umidade: ". $weather->getHumidity() ."%</p>
                                <p styles='font-size: 24px;margin-bottom: 10px;'>🌬️Vento: ". $weather->getWindSpeed(). "km/h</p>
                                <p styles='font-size: 24px;margin-bottom: 10px;'>🌡️Sensação Térmica: ". $weather->getFeelsLike(). "°C</p>
                            </div>
                        </div>
                    </div>"
                );

        $mailer->send($email);
    }
}