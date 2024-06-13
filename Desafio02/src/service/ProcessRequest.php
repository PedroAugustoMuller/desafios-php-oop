<?php

namespace Imply\Desafio02\service;

use DateTime;
use Exception;
use Imply\Desafio02\DAO\OrderDAO;
use Imply\Desafio02\DAO\ProductDAO;
use Imply\Desafio02\DAO\ReviewDAO;
use Imply\Desafio02\DAO\UserDAO;
use Imply\Desafio02\model\Item;
use Imply\Desafio02\model\Order;
use Imply\Desafio02\model\Product;
use Imply\Desafio02\Util\JsonUtil;
use TypeError;

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
        if ((!isset($_SESSION['user_loged']) || $_SESSION['user_loged'] === false) && $this->request['route'] != 'user' ) {
            return ['usuário não logado, acesse user-entrar'];
        }
        if ($this->request['method'] != 'GET' && $this->request['method'] != 'DELETE') {
            try {
                $this->dataRequest = JsonUtil::treatJsonBody();
            } catch (TypeError) {
                return 'dado inválido ou não preenchido';
            }

        }
        $method = $this->request['method'];
        return $this->$method();
    }

    public function get()
    {
        if($this->request['route'] == 'user')
        {
            if ($this->request['resource'] == 'sair') {
                $_SESSION['user_loged'] = false;
                $_SESSION['user_permission'] = 'client';
                $_SESSION['user_id'] = false ;
                return 'saindo do usuário';
            }
        }
        if ($this->request['route'] == 'pedidos') {
            $orderDAO = new OrderDAO();
            if (!empty($this->request['filter'] && is_numeric($this->request['filter']))) {
                return $orderDAO->readOrderById($this->request['filter']);
            }
            if ($this->request['resource'] == 'listarAll') {
                return $orderDAO->readAllOrders();
            }
            return $orderDAO->readUsersOrders($_SESSION['user_id']);
        }
        if ($this->request['route'] == 'produtos') {
            $productDAO = new ProductDAO();
            if (!empty($this->request['filter'] && is_numeric($this->request['filter']))) {
                return $productDAO->readProductById($this->request['filter']);
            }
            if ($this->request['resource'] == 'inativos') {
                return $productDAO->readInactiveProducts();
            }
            return $productDAO->readAllProducts();
        }
        return 'método inválido';
    }

    private function post()
    {
        if ($this->request['route'] == 'user') {
            $userDao = new UserDAO();
            if ($this->request['resource'] == 'entrar') {
                $indexes = ['login','password'];
                if(!$this->validateArrays($indexes))
                {
                    return "Nem todos os dados foram preenchidos";
                }
                $response = $userDao->userLogin($this->dataRequest['login'],$this->dataRequest['password']);
                if(!is_array($response))
                {
                    return $response;
                }
                $_SESSION['user_id'] = $response['user_id'];
                $_SESSION['user_permission'] = $response['access'];
                $_SESSION['user_loged'] = true;
                return 'Usuário logado com sucesso';
            }
        }
        if ($this->request['route'] == 'pedidos') {
            $orderDAO = new OrderDAO();
            if ($this->request['resource'] == 'criar') {
                    if (isset($this->dataRequest['items'])) {
                        $items = array();
                        foreach ($this->dataRequest['items'] as $item) {
                            $productId = $item['item_product_id'];
                            $quantity = $item['quantity'];
                            $price = $item['price'];
                            $title = $item['title'];
                            $items[] = new Item(0, 0, $productId, $quantity, $price, $title);
                        }
                        $orderUserId = $_SESSION['user_id'];
                        $orderdate = new DateTime($this->dataRequest['order_date']);
                        $status = $this->dataRequest['status'];
                        $order = new Order(0, $orderUserId, $orderdate, $status, $items);
                        return $orderDAO->insertOrder($order);
                    }
            }
        }
        if ($this->request['route'] == 'produtos') {
            $productDAO = new ProductDAO();
            if ($this->request['resource'] == 'criar') {
                $error = 'Nem todos os dados foram preenchidos';
                try {
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
                        return ['Produto inserido com sucesso - id: ' . $response];
                    }
                    $error = 'Erro ao inserir Produto';
                } catch (Exception $exception) {
                    return $exception->getMessage();
                }
                return $error;
            }
        }
        return 'método inválido';
    }

    private function put()
    {
        if ($this->request['route'] == 'produtos') {
            $productDAO = new ProductDAO();
            if ($this->request['resource'] == 'atualizar') {
                $indexes = ['title', 'price', 'description', 'category', 'image'];
                if(!$this->validateArrays($indexes))
                {
                    return "Nem todos os indexes foram preenchidos";
                }
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
            if ($this->request['resource'] == 'imagem') {
                $indexes = ['image'];
                if(!$this->validateArrays($indexes))
                {
                    return "Imagem não foi definida";
                }
                $id = $this->request['filter'];
                $imageData = $this->dataRequest['image'];
                $treatProductImage = new treatProductImage($id, $imageData);
                $imagePath = $treatProductImage->saveImage();
                if($imagePath instanceof Exception)
                {
                    return $imagePath;
                }
                $response = $productDAO->setProductImage($imagePath, $id);
                if ($response) {
                    return 'Imagem atualizada com sucesso';
                }
                return ['Erro ao atualizar Imagem'];
            }
        }
        if ($this->request['route'] == 'review') {
            $reviewDAO = new ReviewDAO();
            if ($this->request['resource'] == 'atualizar') {
                $indexes = ['product_id','rate','count'];
                if(!$this->validateArrays($indexes))
                {
                    return "Nem todos os indexes foram preenchidos";
                }
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
        return 'método inválido';
    }

    private function delete()
    {
        if ($this->request['route'] == 'pedidos') {
            $orderDAO = new OrderDAO();
            if ($this->request['resource'] == 'excluir') {
                return $orderDAO->softDeleteOrderById($this->request['filter']);
            }
            if ($this->request['resource'] == 'cancelar') {
                //TODO SUBSTITUIR DATAREQUEST['ORDER_USER_ID'] POR UMA VARIÁVEL SALVA EM $_SESSION OU TOKEN
                return $orderDAO->cancelOrderById($this->request['filter'], 2);
                //TODO SUBSTITUIR DATAREQUEST['ORDER_USER_ID'] POR UMA VARIÁVEL SALVA EM $_SESSION OU TOKEN
            }
        }
        if ($this->request['route'] == 'produtos') {
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
        return 'método inválido';
    }

    private function validateArrays(array $indexes) : bool
    {
        foreach ($indexes as $index) {
            if (!isset($this->dataRequest[$index])) {
                return false;
            }
        }
        return true;
    }
}