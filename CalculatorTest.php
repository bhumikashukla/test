<?php
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-07-29 at 13:00:24.
 */
class CalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Calculator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Calculator;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Calculator::add
     * @todo   Implement testAdd().
     */
    public function testAdd()
    {
        // Remove the following lines when you implement this test.
        /*$this->markTestIncomplete(
          'This test has not been implemented yet.'
        );*/
		 $o = new Calculator;
        $this->assertEquals(0, $o->add(0, 0));
    }
}
