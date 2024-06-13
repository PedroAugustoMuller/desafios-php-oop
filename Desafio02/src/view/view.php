<?php
namespace Imply\Desafio02\view;

require_once '../../vendor/autoload.php';

use Imply\Desafio02\controller\controller;

$controller = new controller();
$products = $controller->getProductsFromDb();
function createTableRow($products) : void
{
    foreach ($products as $product) {
        if(!empty($product->getImage()))
        {
            $image = "<td><img src='" . $product->getImage() . "' alt='product-image' class='img-thumbnail'</td>";
        }
        else
        {
            $image = "<td><img src='../../public/images/products/default-product-image.png' alt='product-image' class='img-thumbnail'</td>";
        }
        echo "<tr>";
        echo "<td>" . $product->getId() . "</td>";
        echo "<td>" . $product->getTitle() . "</td>";
        echo "<td> R$ " . $product->getPrice() . "</td>";
        echo "<td>" . $product->getDescription() . "</td>";
        echo "<td>" . $product->getCategory() . "</td>";
        echo $image;
        echo "<td>" . $product->getReviewRate() . "</td>";
        echo "</tr>";
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/styles/index.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="../../public/scripts/script.js"></script>
    <title>Produtos</title>
</head>
<body>
<table class="table table-dark">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Título</th>
        <th scope="col">Preço</th>
        <th scope="col">Descrição</th>
        <th scope="col">Categoria</th>
        <th scope="col">Imagem</th>
        <th scope="col">Review</th>
    </tr>
    </thead>
    <tbody>
    <?php createTableRow($products); ?>
    </tbody>
</table>
</body>
</html>
