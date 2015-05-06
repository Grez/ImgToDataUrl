<?php

namespace Teddy;

/**
 * Class ImgToDataUrl
 * @package Teddy
 *
 * Converts images in CSS to DataUrl
 * Converts only images with size <= $this->maxSize
 */
class ImgToDataUrl
{

    /** @var string */
    protected $css = '';

    /** @var string */
    protected $path = '';

    /** @var string */
    protected $wwwDir = '';

    /** @var int [KB] */
    protected $maxSize = 3;


    /**
     * @param string $wwwDir ($_SERVER['DOCUMENT_ROOT'] as default)
     */
    public function __construct($wwwDir = '')
    {
        $this->wwwDir = ($wwwDir != '') ? $wwwDir : $_SERVER['DOCUMENT_ROOT'];
    }

    /**
     * Allows to parse file relative paths (./img.jpg) etc.
     * @param \SplFileInfo $file
     * @return null
     */
    public function setCssFromFile(\SplFileInfo $file)
    {
        $this->path = $file->getPath();
        $this->css = file_get_contents($file);
    }

    /**
     * @param string $css
     * @return null
     */
    public function setCss($css)
    {
        $this->css = $css;
    }

    /**
     * @param int $maxSize
     * @return null
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * Tries to find every img and convert it to dataStream
     * @return string
     */
    public function convert()
    {
        echo '<pre>';
        $matches = array();
        preg_match_all("/url\((\"|'|)?((.*\.(png|gif|jpg))(\"|'|))\)/Ui", $this->css, $matches);

        foreach ($matches[2] as $match) {
            $origMatch = $match;
            $match = trim($match, "\t\n\r\0\x0B'\"");

            if (strncmp('http', $match, 4) === 0 || strncmp('//', $match, 2) === 0) {
                continue; // ignore absolute URL
            }

            if (strncmp($match, './', 2) === 0) {
                $match = substr($match, 2);
            }

            if (strncmp($match, '/', 1) === 0 || $this->path == '') {
                $match = substr($match, 1);
                $path = $this->wwwDir;
            } else {
                $path = $this->path;
            }

            $img = $path . '/' . $match;
            if (file_exists($img) && filesize($img) <= ($this->maxSize * 1024)) {
                $type = pathinfo($img, PATHINFO_EXTENSION);
                $data = file_get_contents($img);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $this->css = str_replace('(' . $origMatch . ')', '(' . $base64 . ')', $this->css);
            }
        }

        return $this->css;
    }

}
