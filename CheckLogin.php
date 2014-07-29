<?php
require_once "Login.php";
class CheckLogin extends PHPUnit_Framework_TestCase
{
    protected $Login;
	
	protected function setUp() {
        $this->user = new Login();
        $this->user->setName("Tom");
    }
	
	protected function tearDown() {
        unset($this->Login);
    }
	
	public function testcheck_login() {
        $Login = new Login();
        $expected = "Hello World";
        $actual = $Login->checklogin();
        $this->assertEquals($expected, $actual);
    }
}
?>