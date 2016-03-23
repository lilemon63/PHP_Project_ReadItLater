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
		$this->fp = @fsockopen("localhost", 8080, $errno, $errstr, 0.4);
    }
    
    /**
     * @Then I shoud have a web server started
     */
    public function iShoudHaveAWebServerStarted()
    {
		PHPUnit_Framework_Assert::assertNotNull($this->fp);		
    }


    /**
     * @Given PdoSql extension is loaded
     */
    public function pdosqlExtensionIsLoaded()
    {
        PHPUnit_Framework_Assert::assertTrue(extension_loaded("pdo_mysql"));
    }
    
    /**
     * @When I run the route to create my database
     */
    public function iRunTheRouteToCreateMyDatabase()
    {
		
		
		$ch = curl_init("http://localhost:8080/system/createDB");
		curl_exec($ch);
		//"http://localhost:8080/system/createDB"
        //throw new PendingException();
    }

    /**
     * @Then I should have a database created
     */
    public function iShouldHaveADatabaseCreated()
    {
        $pdo = new PDO("mysql:host=127.0.0.1", "Lilemon", "a1z2e3r4");
		$stmt = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$this->db'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());
    }


}
