<?php
namespace Imply\Desafio02;

require_once "../vendor/autoload.php";

use Imply\Desafio02\controller\controller;

$controller = new controller();
$products = $controller->getProductsFromApi();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <?php foreach ($products as $product) { ?>
            <?php echo "<pre>"; ?>
            <?php var_dump($product) ?>
            <?php echo "<pre>"; ?>
            <img src=<?php echo $product->image?>>
            <?php echo "<pre>"; ?>
        <?php }?>
    </table>


</body>
</html>
