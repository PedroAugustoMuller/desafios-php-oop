<?php

namespace Imply\Desafio02\service;

use InvalidArgumentException;

class treatProductImage
{
    private int $productId;
    private string $imageData;

    /**
     * @param int $productId
     * @param string $imageData
     */
    public function __construct(int $productId, string $imageData)
    {
        $this->productId = $productId;
        $this->imageData = $imageData;
    }

    public function saveImage(): InvalidArgumentException|string
    {
        $targetFileData = explode(',', $this->imageData);
        $targetFileData[1] = base64_decode($targetFileData[1]);
        return $this->createNewFile($targetFileData);
    }

    function createNewFile(array $targetFileData): InvalidArgumentException|string
    {
        $imageFiles = ['jpeg', 'jpg', 'png','gif', 'svg'];
        $newDirpath = '../public/images/products';
        $fileExtension = preg_split('#(/|;)#', $targetFileData[0]);
        $newFilePath = $newDirpath . '/' . $this->productId . '.' . $fileExtension[1];
        if(!in_array($fileExtension, $imageFiles))
        {
            return new InvalidArgumentException("Extensão de arquivo inválida");
        }
        $newFile = fopen($newFilePath, 'w');
        fwrite($newFile, $targetFileData[1]);
        fclose($newFile);
        return "../" . $newFilePath;
    }

}