<?php
require_once "Login.php";
class CheckLogin extends PHPUnit_Framework_TestCase
{
    protected $user;
	
	protected function setUp() {
        $this->user = new User();
        $this->user->setName("Tom");
    }
	
	protected function tearDown() {
        unset($this->user);
    }
	
	public function check_login() {
        $user = new User();
        $expected = "123";
        $actual = $user->checklogin();
        $this->assertEquals($expected, $actual);
    }
}
?>