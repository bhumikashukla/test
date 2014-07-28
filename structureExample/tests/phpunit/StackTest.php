<?php
/**
 * Holds a class for performing general unit tests
 *
 * PHP Version 5
 *
 * @created 07/15/2010
 * @updated 05/13/2013
 *
 * @category   UnitTests
 * @package    UnitTests
 * @author     Mike Kromarek <mkromarek@highline.edu>
 * @license    http://lic.org/lic.php  HCC
 * @version    $Revision$
 * @link       /structureExample/tests/phpunit/StackTest.php Stack Test
 */

/**
 * Include the PHPUnit Framwork so we can extend the TestCase class
 */
require_once 'PHPUnit/Autoload.php';


/**
 * A class for performing Unit Tests
 *
 * @category   UnitTests
 * @package    UnitTests
 * @license    http://lic.org/lic.php  HCC
 * @version    $Revision$
 * @link       /structureExample/tests/phpunit/StackTest.php Stack Test
 */
class StackTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests pushing and popping of elements on and off of an array
     *
     * @return Void
     */
    public function testPushAndPop()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack)-1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
}
