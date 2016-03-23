<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

require_once 'vendor/autoload.php';
//require_once 'vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
	private $db;
	private $fp;
	
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
		$this->db = "RIT_DB";
    }
    
    /**
     * @Given The web server is started
     */
    public function theWebServerIsStarted()
    {		
		$this->fp = @fsockopen("localhost", 8080, $errno, $errstr, 0.4); //(line 47)
		
		//PHPUnit_Framework_Assert::assertNotNull($fp);		
    }

    /**
     * @Then I should assert true
     */
    public function iShouldAssertTrue()
    {
				
		PHPUnit_Framework_Assert::assertNotNull($this->fp);		
		//PHPUnit_Framework_Assert::assertNotNull($fp);		
    }
}
