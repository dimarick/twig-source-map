<?php

namespace Dimarick\TwigSourceMap;

/**
 * Class MapFile
 */
class MapFile
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $path;

    /**
     * MapFile constructor.
     * @param $source
     * @param $path
     */
    public function __construct($source, $path)
    {
        $this->source = $source;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
