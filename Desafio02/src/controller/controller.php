<?php

namespace Imply\Desafio02\controller;

    use Exception;
    use Imply\Desafio02\service\FakeStoreAPI;
    use Imply\Desafio02\Util\RoutesUtil;
    use InvalidArgumentException;

    class controller
    {
        public function getProductsFromDb()
        {
            $route = RoutesUtil::getRoutes();
            if(!)

//            $fakeStore = new FakeStoreAPI();
//            return $fakeStore->getApiProducts();
        }

        public function treatRequest()
        {
            try{
                $route = RoutesUtil::getRoutes();
                if($route instanceof Exception)
                {
                    throw $route;
                }
                if($route['METHOD'] != 'GET' || $route['METHOD'] != 'DELETE')
                {

                }

            }catch(InvalidArgumentException $invalidArgumentException)
            {

            }
        }
    }