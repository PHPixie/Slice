<?php

namespace PHPixie\Slice\Type;

use PHPixie\Slice;

class Merge extends Slice\Data\Implementation
{
    protected $baseData;
    protected $overrideData;
    protected $nullObject;

    public function __construct(Slice $sliceBuilder, Slice\Data $baseData, Slice\Data $overrideData)
    {
        parent::__construct($sliceBuilder);
        $this->baseData = $baseData;
        $this->overrideData = $overrideData;
        $this->nullObject = new \stdClass();
    }

    public function keys(?string $path = null, bool $isRequired = false) : ?array
    {
        $data = $this->getData($path, $isRequired, array());
        return array_keys($data);
    }

    public function getData(?string $path = null, bool $isRequired = false,  $default = null)
    {
        $base = $this->baseData->get($path, $this->nullObject);
        $override = $this->overrideData->get($path, $this->nullObject);

        $baseIsNull = $base === $this->nullObject;
        $overrideIsNull = $override === $this->nullObject;

        if($baseIsNull && $overrideIsNull) {
            if($isRequired) {
                throw new \PHPixie\Slice\Exception("Data for '$path' is not set.");
            }

            return $default;
        }

        if($overrideIsNull) {
            return $base;
        }

        if($baseIsNull || !is_array($override) || !is_array($base)) {
            return $override;
        }

        return array_replace_recursive($base, $override);
    }

    public function slice(?string $path = null) : Slice\Data\Slice
    {
        return $this->arraySlice($path);
    }

    public function arraySlice(?string $path = null) : ArrayData\Slice
    {
        $data = $this->get($path);
        return $this->sliceBuilder->arraySlice($data, $path);
    }

    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->getData(null, false, array()));
    }
}
