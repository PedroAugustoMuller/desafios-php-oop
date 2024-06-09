<?php

namespace Imply\Desafio02\controller;

    use Imply\Desafio02\service\FakeStoreAPI;

    class controller
    {
        public function getProductsFromApi()
        {
            $fakeStore = new FakeStoreAPI();
            return $fakeStore->getApiProducts();
        }
    }