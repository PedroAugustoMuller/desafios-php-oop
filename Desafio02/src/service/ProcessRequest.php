<?php

namespace Imply\Desafio02\service;

use Imply\Desafio02\DAO\ProductDAO;
use Imply\Desafio02\DAO\ReviewDAO;
use Imply\Desafio02\model\Product;
use Imply\Desafio02\Util\JsonUtil;

class ProcessRequest
{
    private array $request;
    private array $dataRequest;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function processRequest()
    {
        if ($this->request['method'] != 'GET' && $this->request['method'] != 'DELETE') {
            $this->dataRequest = JsonUtil::treatJsonBody();
        }
        $method = $this->request['method'];
        return $this->$method();
    }

    public function GET()
    {
        $productDAO = new ProductDAO();
        if (!empty($this->request['filter'] && is_numeric($this->request['filter']))) {
            return $productDAO->readProductById($this->request['filter']);
        }
        return $productDAO->readAllProducts();
    }

    private function post()
    {
        $productDAO = new ProductDAO();
        $title = $this->dataRequest['title'];
        $price = (float)$this->dataRequest['price'];
        $description = $this->dataRequest['description'];
        $category = $this->dataRequest['category'];
        $image = $this->dataRequest['image'];
        $produto = new Product(0, $title, $price, $description, $category, $image);
        $response = $productDAO->insertProduct($produto);
        if($response > 0)
        {
            $reviewDAO = new ReviewDAO();
            $reviewDAO->insertIntoReview($response);
            return $success = ['Produto inserido com sucesso'];
        }
        return $error = ['Erro ao inserir Produto'];
    }

    private function put()
    {
        $productDAO = new ProductDAO();
        $id = $this->request['filter'];
        $title = $this->dataRequest['title'];
        $price = (float)$this->dataRequest['price'];
        $description = $this->dataRequest['description'];
        $category = $this->dataRequest['category'];
        $image = $this->dataRequest['image'];
        $produto = new Product($id, $title, $price, $description, $category, $image);
        $response = $productDAO->updateProduct($produto);
        if($response)
        {
            return $success = ['Produto atualizado com sucesso'];
        }
        return $error = ['Erro ao atualizar Produto'];
    }

    private function delete()
    {
        $productDAO = new ProductDAO();
        $response = $productDAO->deleteProduct($this->request['filter']);
        if($response)
        {
            return $success = ['Produto desativado com sucesso'];
        }
        return $error = ['Erro ao desativar produto'];
    }
}