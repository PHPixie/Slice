<?php

namespace PHPixie\Slice\Data;

interface Slice extends \PHPixie\Slice\Data
{
    public function path($relativePath = null);
    public function set($relativePath, $value);
}