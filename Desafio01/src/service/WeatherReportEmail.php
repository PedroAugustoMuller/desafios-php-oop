<?php

namespace Imply\Desafio01\service;

use Imply\Desafio01\model\Weather;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class WeatherReportEmail
{
    function sendEmail(Weather $weather, string $targetEmail)
    {
        $transport = Transport::fromDsn('smtp://pedro.muller.a@gmail.com:xkrzxbcpmlufwnke@smtp.gmail.com:587');
        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('hello@example.com')
            ->to($targetEmail)
            ->subject("Clima em: " . $weather->getCityInfo() . " - " . $weather->getStringTime())
            ->text('')
            ->html("<div style='width: 1000px;margin: 50px auto;background: #bacef7;padding: 20px;border-radius: 10px;display: grid;justify-content: center;'>
                <div style='text-align: center;'>
                    <p style='font-size: 36px;margin-bottom: 15px;color: black;font-weight: bold;'>" . $weather->getCityInfo() . "</p>
                </div>
                <div style='display: grid; margin: 0 auto;'>
                    <div style='align-items: center; justify-content: center; column-gap: 10px; text-align:center;'>
                        <p style='font-size: 36px;font-weight: bold;color: #4d73c0;text-align: center;text-decoration: underline;'>" . $weather->getTemp() . "°C</p>
                        <img style='text-align:center;' src='https://openweathermap.org/img/wn/" . $weather->getIcon() . "@2x.png' alt=''>
                    </div>
                    <div style='text-align: center;'>
                        <p style='font-weight: bold;font-size: 24px;margin-bottom: 10px;'>📔Data: " . $weather->getStringTime() . "</p>
                        <p style='font-weight: bold;font-size: 24px;margin-bottom: 10px;'>⛅Descrição: " . $weather->getDescription() . "</p>
                        <p style='font-weight: bold;font-size: 24px;margin-bottom: 10px;'>🌫️Umidade: " . $weather->getHumidity() . "%</p>
                        <p style='font-weight: bold;font-size: 24px;margin-bottom: 10px;'>🌬️Vento: " . $weather->getWindSpeed() . "km/h</p>
                        <p style='font-weight: bold;font-size: 24px;margin-bottom: 10px;'>🌡️Sensação Térmica: " . $weather->getFeelsLike() . "°C</p>
                    </div>
                </div>
            </div>");
        $mailer->send($email);
    }
}
