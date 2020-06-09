<?php
class Upload{
    private $dir,$folder;
    private $size,$images;
    private $trueSize,$trueType,$trueErrorCode;
    private $paths = [];
    private $message = [];
    public function __construct($images, $dir='/uploader/',$folder='images/')
    {
        $this->dir = $_SERVER['DOCUMENT_ROOT'].$dir;
        $this->images = $images;
        $this->folder = $folder;
        $this->makeFolder();

    }

    /**
     * start action for move image
     */
    public function startMove(){
        foreach ($this->images as $image){
            if(is_array($image['name'])){
                $this->multipleImages($image);
            }else{
                $this->singleImage($this->images);
            }
        }
    }

    /**
     * set image size
     * @param integer|string $size
     */
    public function setSize($size){
        $this->size = $size;
    }

    /**
     * get images path
     * @return array
     */
    public function getPath(){
        return $this->paths;
    }

    /**
     * get error message
     * @return array
     */
    public function getMessage(){
        return current($this->message);
    }

    /**
     * upload single image
     * @param array $image
     */
    private function singleImage($image){
        $image = current($image);
        $this->check($image);
        if($this->finalCheck() == true){
            $changeName = $this->changeName($image['name']);
            $this->moveImage($image['tmp_name'],$changeName);
        }
    }

    /**
     * upload multi images
     * @param array $images
     */
    private function multipleImages($images){
        foreach ($images['tmp_name'] as $key=>$tmp){
            $this->check($images,$key);
            if($this->finalCheck()){
                $changeName = $this->changeName($images['name'][$key]);
                if($this->moveImage($tmp,$changeName) == false){
                    break;
                }
            }else{
                $this->rollback();
                break;
            }
        }
    }

    /**
     * upload image
     * @param string $tmp
     * @param string $name
     * @return bool
     */
    private function moveImage($tmp, $imageName){
        $name = $this->dir.$this->folder.$imageName;
        $uploaded = move_uploaded_file($tmp,$name);
        if($uploaded == true){
            $this->paths[] = 'uploader/'.$this->folder.$imageName;
            return true;
        }else{
            $this->message[] = "مشکلی ر حین اپلود رخ داده است بعدا امتحان کنید";
            $this->rollback();
            return false;
        }
    }

    /**
     * final check for image
     * @return bool
     */
    private function finalCheck(){
        if($this->trueErrorCode == true) {
            if ($this->trueType == true) {
                if ($this->trueSize == true) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param array $image
     * @param null $key
     */
    private function check($image, $key=null){
        $error = !is_null($key) ? $image['error'][$key] : $image['error'];
        $type = !is_null($key) ? $image['type'][$key] :$image['type'];
        $size = !is_null($key) ? $image['size'][$key] :$image['size'];
        $name = !is_null($key) ? $image['name'][$key] :$image['name'];
        $this->allCheck($error,$type,$size,$name);
    }

    /**
     * @param string $errorCode
     * @param string $type
     * @param string $size
     * @param string $name
     */
    private function allCheck($errorCode, $type, $size, $name){
        $this->checkErrorCode($errorCode,$name);
        $this->checkType($type, $name);
        $this->checkSize($size, $name);

    }

    /**
     * check default error code
     * @param integer|string $error
     * @param string $name
     */
    private function checkErrorCode($error, $name){
        if($error > 0){
            switch ($error){
                case 1:
                    $size = str_replace(['M','G'],'',ini_get('upload_max_filesize'));
                    $this->message[] = "سایز تصویر {$name} بزرگتر از {$size} مگابایت است"."<br>";
                    break;
            }
            $this->trueErrorCode = false;
        }else{
            $this->trueErrorCode = true;
        }
    }

    /**
     * check image size
     * @param integer|string $imageSize
     * @param string $name
     */
    private function checkSize($imageSize , $name){
        $size = $imageSize / 1024; // KB
        if(!empty($imageSize)) {
            if ($size > $this->size) {
                $_ = $this->size / 1000;
                $this->message[] = "سایز تصویر {$name} بزرگتر از {$_} مگابایت است" . "<br>";
                $this->trueSize = false;
            } else {
                $this->trueSize = true;
            }
        }
    }

    /**
     * check image type
     * @param string $imageType
     * @param string $name
     */
    private function checkType($imageType, $name){
        $types = ['image/jpg','image/jpeg','image/png'];
        if(!empty($imageType)) {
            if (!in_array($imageType, $types)) {
                $this->message[] = "تایپ تصویر {$name} نامناسب است. تایپ های مجاز [ jpg | png | jpeg ]" . "<br>";
                $this->trueType = false;
            } else {
                $this->trueType = true;
            }
        }
    }

    /**
     * change image name
     * @param string $nameImage
     * @return string
     */
    private function changeName($nameImage){
        $name = '';
        $explodImage = explode('.',$nameImage);
        $last = array_key_last($explodImage);
        $extention = $explodImage[$last];
        $imageName = str_replace(' ','-',$explodImage[0]);
        $i = 1;
        while (true){
            $name = $imageName."_$i.".$extention;
            if(file_exists($this->dir.$this->folder.$name)){
                $i++;
            }else{
                break;
            }
        }
        return $name;
    }

    /**
     * unlink image if upload hav error
     */
    private function rollback(){
        if(!empty($this->paths)){
            foreach ($this->paths as $path){
                if(file_exists($path)){
                    unlink($path);
                }
            }
        }
    }

    /**
     * if not exist path then make folder to path
     */
    private function makeFolder(){
        if(!file_exists($this->dir)){
            mkdir($this->dir);
        }
        if(!file_exists($this->dir.$this->folder)){
            mkdir($this->dir.$this->folder);
        }

    }
}

?>