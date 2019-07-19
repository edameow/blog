<?php
/**
 * Created by PhpStorm.
 * User: gryatka
 * Date: 15.04.2019
 * Time: 9:47
 */

namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => 'Картинка',
        ];
    }

    public function uploadFile(UploadedFile $file, $currentImage, $folder = 'articles')
    {
        $this->image = $file;
        if ($this->validate()) {
            $this->deleteCurrentImage($currentImage, $folder);
            return $this->saveImage($folder);
        }
    }

    private function deleteCurrentImage($currentImage, $folder)
    {
        if ($this->fileExists($currentImage, $folder)) {
            unlink($this->getFolder($folder) . $currentImage);
        }
    }

    private function fileExists($currentImage, $folder)
    {
        return file_exists($this->getFolder($folder) . $currentImage) && is_file($this->getFolder($folder) . $currentImage);
    }

    private function getFolder($folder)
    {
        return "images/{$folder}/";
    }

    private function saveImage($folder)
    {
        $fileName = $this->generateFileName();
        $this->image->saveAs($this->getFolder($folder) . $fileName);
        return $fileName;
    }

    private function generateFileName()
    {
        return strtolower(md5(uniqid($this->image->baseName))) . '.'  . $this->image->extension;
    }


}