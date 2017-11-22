<?php

namespace PHPixie\Slice\Data;

interface Slice extends \PHPixie\Slice\Data
{
    public function path(?string $relativePath = null) : ?string ;
}
