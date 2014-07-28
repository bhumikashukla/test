<?php
/**
 * Include the simpletest file so we can extend TestSuite
 */
require_once 'simpletest/simpletest.php';
/**
 * Include the JUnitXMLReporter class so the output is jUnit and xUnit compatible
 */
require_once 'simpletest/extensions/junit_xml_reporter.php';
 
class MyTests extends TestSuite
{
    function __construct()
    {
        parent::__construct();
 
        //add the files containing the tests we want to perform
        //note the use of __DIR__ so we don't have to worry about file location
        //when running the tests in Jenkins
        $this->addFile(__DIR__.'/TemplateTest.php');
    }
 
}
 
$test = new MyTests();
$test->run(new JUnitXMLReporter());
?>