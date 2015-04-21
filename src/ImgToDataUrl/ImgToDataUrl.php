<?php

namespace Teddy;

/**
 * Class ImgToDataUrl
 * @package Teddy
 *
 * Converts images in .css file to dataUrl
 * Converts only images with size <= $this->maxSize and stops converting when it reaches $this->maxSizeTotal
 */
class ImgToDataUrl
{

    /** @var \SplFileInfo */
    protected $file = '';

    /** @var string */
    protected $wwwDir = '';

    /** @var int [KB] */
    protected $maxSize = 5;

    /** @var int [KB] */
    protected $maxSizeTotal = 100;


    /**
     * @param \SplFileInfo $file
     * @param string $wwwDir ($_SERVER['DOCUMENT_ROOT'] as default)
     */
    public function __construct(\SplFileInfo $file, $wwwDir = '')
    {
        $this->file = $file;
        $this->wwwDir = ($wwwDir != '') ? $wwwDir : $_SERVER['DOCUMENT_ROOT'];
    }

    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function setMaxSizeTotal($maxSizeTotal)
    {
        $this->maxSizeTotal = $maxSizeTotal;
    }

    /**
     * Tries to find every img and convert it to dataStream
     * @return string
     */
    public function convert()
    {
        $imgSize = 0;
        $matches = array();
        $css = file_get_contents($this->file);
        preg_match_all("/url\((\"|'|)?((.*\.(png|gif|jpg))(\"|'|))\)/Ui", $css, $matches);

        foreach ($matches[2] as $match) {
            $origMatch = $match;
            $match = trim($match, "\t\n\r\0\x0B'\"");

            if (strncmp('http', $match, 4) === 0 || strncmp('//', $match, 2) === 0) {
                continue; // ignore absolute URL
            }

            if (strncmp($match, './', 2) === 0) {
                $match = substr($match, 2);
            }

            if (strncmp($match, '/', 1) === 0) {
                $match = substr($match, 1);
                $path = $this->wwwDir;
            } else {
                $path = $this->file->getPath();
            }


            $img = $path . '/' . $match;
            if (file_exists($img) && filesize($img) <= ($this->maxSize * 1024) && $imgSize <= $this->maxSizeTotal * 1024) {
                $imgSize += filesize($img);
                $type = pathinfo($img, PATHINFO_EXTENSION);
                $data = file_get_contents($img);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $css = str_replace('(' . $origMatch . ')', '(' . $base64 . ')', $css);
            }
        }

        return $css;
    }

}