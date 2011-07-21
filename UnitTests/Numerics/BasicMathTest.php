<?php
require_once 'PHPUnit/Framework.php';
require_once(dirname(__FILE__) . '/../../Skills/Numerics/BasicMath.php');

 
class BasicMathTest extends PHPUnit_Framework_TestCase
{    
    public function testSquare()
    {    
        $this->assertEquals( 1, \square(1) );
        $this->assertEquals( 1.44, \square(1.2) );
        $this->assertEquals( 4, \square(2) );
    }
}
?>