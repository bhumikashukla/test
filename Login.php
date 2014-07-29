<?php
class Login {
    protected $name;
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
			$this->name = $name;
    }
    public function check_login() {
        return "123";
    }
}
?>