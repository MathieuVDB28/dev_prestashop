<?php

class ImageUpload
{
    protected $basePath;
    protected $success;

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function upload($file)
    {
        $targetPath = $this->basePath . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $this->success = true;
        } else {
            $this->success = false;
        }
    }

    public function success()
    {
        return $this->success;
    }
}