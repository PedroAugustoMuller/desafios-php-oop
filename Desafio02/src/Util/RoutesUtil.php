<?php

namespace Imply\Desafio02\Util;
use Exception;
use InvalidArgumentException;
require_once __DIR__ . '/ConstantsUtil.php';

class RoutesUtil
{
    public static function getRoutes() : InvalidArgumentException|array
    {
        $urls = self::getURLs();
        $request = [];
        $request['route'] = $urls[0] ?? null;
        $request['resource'] = $urls[1] ?? null;
        $request['filter'] = $urls[2] ?? null;
        $request['method'] = $_SERVER['REQUEST_METHOD'];

        return self::validateRoutes($request);
    }
    private static function getURLs(): array
    {
        $uri = $_SERVER['REQUEST_URI'];
        $pattern = '#/Desafio02/src/index.php/#i';
        $uri = preg_replace($pattern, '', $uri);
        return explode('/',$uri);
    }

    private static function validateRoutes(array $request): InvalidArgumentException|Exception|array
    {
        try
        {
            if(!in_array($request['route'],ROUTES))
            {
                header('HTTP/1.1 400 Bad Request');
                throw new InvalidArgumentException("400 - Bad Request - Rota inválida");
            }
            if(!in_array($request['resource'], RESOURCES))
            {
                header('HTTP/1.1 404 Not Found');
                throw new InvalidArgumentException("404 - Not Found - Recurso Inexistente");
            }
            return $request;
        }catch(InvalidArgumentException $invalidArgumentException)
        {
            return $invalidArgumentException;
        }
    }
}