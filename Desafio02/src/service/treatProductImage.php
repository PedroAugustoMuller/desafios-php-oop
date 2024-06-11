<?php

namespace Imply\Desafio02\service;

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

    public function saveImage(): string
    {
        $targetFileData = explode(',', $this->imageData);
        $targetFileData[1] = base64_decode($targetFileData[1]);
        return $this->createNewFile($targetFileData);
    }
    function createNewFile(array $targetFileData) : string
    {
        $newDirpath = '../public/images/products';
        $fileExtension = preg_split('#(/|;)#',$targetFileData[0]);
        $newFilePath = $newDirpath . '/' . $this->productId . '.' . $fileExtension[1];
        $newFile = fopen($newFilePath, 'w');
        fwrite($newFile, $targetFileData[1]);
        fclose($newFile);
        return "../".$newFilePath;
    }
}