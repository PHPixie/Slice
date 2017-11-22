<?php

namespace PHPixie\Slice\Data;

use \PHPixie\Slice;

abstract class Implementation implements \PHPixie\Slice\Data
{
    protected $sliceBuilder;

    public function __construct(Slice $sliceBuilder)
    {
        $this->sliceBuilder = $sliceBuilder;
    }

    public function get(?string $key = null,  $default = null)
    {
        return $this->getData($key, false, $default);
    }

    public function getRequired(?string $key = null)
    {
        return $this->getData($key, true);
    }

    /**
     * @return string
     */
    protected function mergePath(?string $prefix, ?string $path = null) : string
    {
        if($prefix === null)
            return $path;

        if ($path === null)
            return $prefix;

        return $prefix.'.'.$path;
    }
}
