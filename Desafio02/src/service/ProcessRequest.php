<?php

namespace Imply\Desafio02\service;
session_start();
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
        if((!isset($_SESSION['user_loged']) || $_SESSION['user_loged'] === false) && $this->request['route'] != 'user')
        {
            return ['usuário não logado, acesse user-entrar'];
        }
        if ($this->request['method'] != 'GET' && $this->request['method'] != 'DELETE') {
            $this->dataRequest = JsonUtil::treatJsonBody();
        }
        $method = $this->request['method'];
        return $this->$method();
    }

    public function get()
    {
        $productDAO = new ProductDAO();
        if (!empty($this->request['filter'] && is_numeric($this->request['filter']))) {
            return $productDAO->readProductById($this->request['filter']);
        }
        if ($this->request['filter']) {
            return $productDAO->readInactiveProducts();
        }
        return $productDAO->readAllProducts();
    }

    private function post()
    {
        if($this->request['route'] == 'user')
        {
            if($this->request['resource'] == 'entrar')
            {
                $_SESSION['user_loged'] = true;
                return "usuario logado";
            }
            if($this->request['resource'] == 'sair')
            {
                $_SESSION['user_loged'] = false;
                return 'saindo do usuário';
            }
        }
        if($this->request['route'] == 'produtos')
        {
            if($this->request['resource'] == 'criar')
            {
                $productDAO = new ProductDAO();
                $title = $this->dataRequest['title'];
                $price = (float)$this->dataRequest['price'];
                $description = $this->dataRequest['description'];
                $category = $this->dataRequest['category'];
                $image = $this->dataRequest['image'];
                $produto = new Product(0, $title, $price, $description, $category, $image);
                $response = $productDAO->insertProduct($produto);
                if ($response > 0) {
                    $reviewDAO = new ReviewDAO();
                    $reviewDAO->insertIntoReview($response);
                    return $success = ['Produto inserido com sucesso - id: ' . $response];
                }
                return $error = ['Erro ao inserir Produto'];
            }
        }
    }

    private function put()
    {
        if ($this->request['route'] == 'produtos') {
            $productDAO = new ProductDAO();
            if ($this->request['resource'] == 'atualizar') {
                $id = $this->request['filter'];
                $title = $this->dataRequest['title'];
                $price = (float)$this->dataRequest['price'];
                $description = $this->dataRequest['description'];
                $category = $this->dataRequest['category'];
                $image = $this->dataRequest['image'];
                $produto = new Product($id, $title, $price, $description, $category, $image);
                $response = $productDAO->updateProduct($produto);
                if ($response) {
                    return ['Produto atualizado com sucesso'];
                }
                return ['Erro ao atualizar Produto'];
            }
            if ($this->request['resource'] == 'imagem')
            {
                $id = $this->request['filter'];
                $imageData = $this->dataRequest['image'];
                $treatProductImage = new treatProductImage($id,$imageData);
                $imagePath = $treatProductImage->saveImage();
                $response = $productDAO->setProductImage($imagePath,$id);
                if ($response) {
                    return $success = ['Imagem atualizada com sucesso'];
                }
                return ['Erro ao atualizar Imagem'];
            }
        }
        if ($this->request['route'] == 'review') {
            $reviewDAO = new ReviewDAO();
            if ($this->request['resource'] == 'atualizar') {
                $reviewData['review_product_id'] = $this->dataRequest['product_id'];
                $reviewData['rate'] = $this->dataRequest['rate'];
                $reviewData['count'] = $this->dataRequest['count'];
                $response = $reviewDAO->updateProductReview($reviewData);
                if ($response) {
                    return ['Review atualizado com sucesso'];
                }
                return ['Erro ao atualizar Review'];
            }
            return ["recurso inexistente"];
        }
    }

    private function delete()
    {
        $productDAO = new ProductDAO();
        $response = false;
        $error = ['Erro na operação'];
        if ($this->request['resource'] == 'reativar') {
            $id = $this->request['filter'];
            $response = $productDAO->reactivateProduct($id);
            $result = ['Produto reativado com sucesso'];
        }
        if ($this->request['resource'] == 'excluir') {
            $response = $productDAO->deleteProduct($this->request['filter']);
            $result = ['Produto desativado com sucesso'];
        }
        if ($response) {
            return $result;
        }
        return $error;
    }
}