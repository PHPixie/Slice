<?php

namespace PHPixie\Slice\Data;

abstract class Implementation implements \PHPixie\Slice\Data
{
    protected $sliceBuilder;

    /**
     * @param \PHPixie\Slice $sliceBuilder
     */
    public function __construct($sliceBuilder)
    {
        $this->sliceBuilder = $sliceBuilder;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        return $this->getData($key, false, $default);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getRequired($key = null)
    {
        return $this->getData($key, true);
    }

    /**
     * @param string $prefix
     * @param string $path
     * @return string
     */
    protected function mergePath($prefix, $path = null)
    {
        if($prefix === null)
            return $path;

        if ($path === null)
            return $prefix;

        return $prefix.'.'.$path;
    }
}
