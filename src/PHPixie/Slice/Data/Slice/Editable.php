<?php

namespace PHPixie\Slice\Data\Slice;

interface Editable extends \PHPixie\Slice\Data\Slice,
                           \PHPixie\Slice\Data\Editable
{
    public function remove($path = null);
    public function set($path, $value);
}