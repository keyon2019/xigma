<?php


namespace App;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Image implements \JsonSerializable
{
    public $path;
    public $url;

    public function __construct($path)
    {
        $this->path = $path;
        $this->url = $this->getUrl();
    }

    public function __toString()
    {
        return $this->path ?? '';
    }

    public function jsonSerialize()
    {
        return $this->getUrl() ?? '';
    }

    /**
     * @param UploadedFile $file
     * @param string $directory
     * @param string $name
     * @return Image
     */
    public static function store($file, $directory = null, $name = null)
    {
        $directory = $directory ? "/$directory" : "";
        if ($name)
            return new self($file->storeAs("images$directory", $name));
        return new self($file->store("images$directory"));
    }

    /**
     * @param UploadedFile $file
     * @return Image
     */
    public function update($file)
    {
        $this->delete();
        $this->path = $file->store('images');
        $this->url = $this->getUrl();
        return $this;
    }

    public function delete()
    {
        Storage::delete($this->path);
        return null;
    }

    public function path()
    {
        return $this->path;
    }

    public function absolutePath()
    {
        return storage_path("app/$this->path");
    }

    public function base64()
    {
        return "data:image/{$this->extension()};base64," . base64_encode(file_get_contents($this->path()));
    }

    private function extension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    private function getUrl()
    {
        return $this->path ? url($this->path) : "";
    }


}