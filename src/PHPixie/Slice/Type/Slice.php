<?php
namespace PHPixie\Slice\Type;

class Slice extends \PHPixie\Slice\Data\Implementation
{
    /** @var \PHPixie\Slice\Data\Slice */
    protected $data;
    /** @var string */
    protected $path;

    /**
     * @param \PHPixie\Slice $sliceBuilder
     * @param mixed           $data
     * @param string           $path
     */
    public function __construct($sliceBuilder, $data = null, $path = null)
    {
        $this->data = $data;
        $this->path = $path;
        parent::__construct($sliceBuilder);
    }

    /**
     * @param string $path
     * @param bool   $isRequired
     * @param mixed  $default
     * @return mixed
     */
    public function getData($path = null, $isRequired = false, $default = null)
    {
        $path = $this->dataPath($path);
        return $this->data->getData($path, $isRequired, $default);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function slice($path = null)
    {
        return $this->data->slice($this->dataPath($path));
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function arraySlice($path = null)
    {
        return $this->data->arraySlice($this->dataPath($path));
    }

    /**
     * @param string $path
     * @param bool   $isRequired
     * @return array
     */
    public function keys($path = null, $isRequired = false)
    {
        return $this->data->keys($this->dataPath($path), $isRequired);
    }

    /**
     * @param string $path
     * @return string
     */
    public function path($path = null)
    {
        $path = $this->dataPath($path);

        if($this->data instanceof \PHPixie\Slice\Data\Slice) {
            $path = $this->data->path($path);
        }

        return $path;
    }

    /**
     * @return \PHPixie\Slice\Iterator
     */
    public function getIterator()
    {
        return $this->sliceBuilder->iterator($this);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function dataPath($path)
    {
        return $this->mergePath($this->path, $path);
    }
}
