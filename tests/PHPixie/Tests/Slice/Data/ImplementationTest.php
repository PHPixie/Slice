<?php

namespace PHPixie\Tests\Slice\Data;

/**
 * @coversDefaultClass \PHPixie\Slice\Data\Implementation
 */
abstract class ImplementationTest extends \PHPixie\Test\Testcase
{
    protected $sliceBuilder;
    
    protected $sliceData;
    
    public function setUp()
    {
        $this->sliceBuilder = $this->quickMock('\PHPixie\Slice');
        $this->sliceData = $this->sliceData();
    }
    
    /**
     * @covers \PHPixie\Slice\Data\Implementation::__construct
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
        
    }

    /**
     * @covers ::get
     * @covers ::getRequired
     * @covers ::getData
     * @covers ::<protected>
     */
    public function testGet()
    {
        $sets = $this->prepareGetDataSets();
        
        foreach($sets as $set) {
            $callable = array($this->sliceData, $set[0]);
            
            if($set[2] == 'exception') {
                $this->assertSliceException(function() use($callable, $set) {
                    call_user_func_array($callable, $set[1]);
                });
                
            }else{
                $this->assertSame($set[2], call_user_func_array($callable, $set[1]));
            }
        }
    }
    
    /**
     * @covers ::arraySlice
     * @covers ::<protected>
     */
    public function testArraySlice()
    {
        $mock = $this->sliceDataMock(array('get', 'path'));
        $data = array('test');
        
        foreach(array(true, false) as $withPath) {
            $path = $withPath ? 'pixie' : null;
            $this->method($mock, 'get', $data, array($path, null), 0);
            $this->method($mock, 'path', 'trixie', array($path), 1);
            
            $slice = $this->getArraySlice();
            $this->method($this->sliceBuilder, 'arraySlice', $slice, array('trixie', $data), 0);
            
            $args = array();
            if($withPath) {
                $args[]= $path;
            }
            $result = call_user_func_array(array($mock, 'arraySlice'), $args);
            $this->assertSame($slice, $result);
        }
    }
    
    protected function assertSliceException($callback)
    {
        $this->assertException($callback, '\PHPixie\Slice\Exception');
    }
    
    protected function getIterator()
    {
        return $this->abstractMock('\PHPixie\Slice\Iterator');
    }
    
    protected function getSlice()
    {
        return $this->abstractMock('\PHPixie\Slice\Type\Slice');
    }
    
    protected function getArraySlice()
    {
        return $this->abstractMock('\PHPixie\Slice\Type\ArrayData\Slice');
    }
        
    abstract protected function prepareGetDataSets();
    abstract protected function sliceData();
    abstract protected function sliceDataMock($methods = null);
}
