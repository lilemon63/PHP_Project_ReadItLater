<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

require_once 'vendor/autoload.php';


/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
	private $db;
	private $fp;
	private $app;
	private $pdo;
	private $url;
	
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
		$this->db = "rit_db";
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
		
		$ch = curl_init("http://localhost:8080/fixture/createDB");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		
    }

    /**
     * @Then I should have a database created
     */
    public function iShouldHaveADatabaseCreated()
    {
		$this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$this->db'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());
    }



    /**
     * @Given The database is already created
     */
    public function theDatabaseIsAlreadyCreated()
    {
		$this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$this->db'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());
    }

    /**
     * @When I run the fixture to create my tables
     */
    public function iRunTheFixtureToCreateMyTables()
    {		
		$ch = curl_init("http://localhost:8080/fixture/createDB");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have my two tables
     */
    public function iShouldHaveMyTwoTables()
    {		
		/*
		 SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'rit_db' and TABLE_NAME = 'rit_link'
		 */ 
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$this->db' and TABLE_NAME = 'rit_link'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());		
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$this->db' and TABLE_NAME = 'rit_categorie'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());		
    }
    
    

    /**
     * @Given a url for the link to add
     */
    public function aUrlForTheLinkToAdd()
    {
		$this->url = "https://github.com/willdurand-edu/php-practicals/blob/master/src/isima/2.md";
		$falseUrl =str_replace(",",".",$this->url);
		$falseUrl = str_replace("+","/",$falseUrl);
		
        $this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
    }

    /**
     * @When I run the route to add a link
     */
    public function iRunTheRouteToAddALink()
    {
		$ch = curl_init("http://localhost:8080/link/add/$this->url");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have this link in base
     */
    public function iShouldHaveThisLinkInBase()
    {
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_url = '$this->url'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());		
    }

	private $name;
	
    /**
     * @Given a categorie name
     */
    public function aCategorieName()
    {
		$this->name = "JS";
		
        $this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
    }

    /**
     * @When I run the route to create a categorie
     */
    public function iRunTheRouteToCreateACategorie()
    {
		$ch = curl_init("http://localhost:8080/categ/add/$this->name");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have this categorie created
     */
    public function iShouldHaveThisCategorieCreated()
    {
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_categorie WHERE cat_name = '$this->name'");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());		
    }
    
    private $idLink;
    private $idCateg;

    /**
     * @Given a categorie and a link
     */
    public function aCategorieAndALink()
    {
		$this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
		
		$url = "www.example.com";
		$name = "categ_test";
		
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_categorie WHERE cat_name = '$name'");
		if(!(bool) $stmt->fetchColumn()){
			$stmt = $this->pdo->query("insert into $this->db.rit_categorie(cat_name) values ('$name')");
		}
		
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_url = '$url'");
		if(!(bool) $stmt->fetchColumn()){
			$stmt = $this->pdo->query("insert into $this->db.rit_link(lnk_url,lnk_status) values ('$url',1)");
		}
		
		$stmt = $this->pdo->query("SELECT cat_id FROM $this->db.rit_categorie WHERE cat_name = '$name'");
		$this->idCateg = $stmt->fetchColumn(0);
		
		
		$stmt = $this->pdo->query("SELECT lnk_id FROM $this->db.rit_link WHERE lnk_url = '$url'");
		$this->idLink =  $stmt->fetchColumn(0);
    }

    /**
     * @When I run the route to change categorie
     */
    public function iRunTheRouteToChangeCategorie()
    {
		$ch = curl_init("http://localhost:8080/categ/swap/$this->idLink/$this->idCateg");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have the categorie changed for this link
     */
    public function iShouldHaveTheCategorieChangedForThisLink()
    {
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_id = $this->idLink AND cat_id = $this->idCateg");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());
		
		$this->pdo->query("DELETE FROM $this->db.rit_link where lnk_id = $this->idLink");
		$this->pdo->query("DELETE FROM $this->db.rit_categorie where cat_id = $this->idCateg");
    }

    /**
     * @Given a categorie to remove
     */
    public function aCategorieToRemove()
    {
		$this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
		$name = "tmp_categRemove";
		
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_categorie WHERE cat_name = '$name'");
		if(!(bool) $stmt->fetchColumn()){
			$stmt = $this->pdo->query("insert into $this->db.rit_categorie(cat_name) values ('$name')");
		}
				
		$stmt = $this->pdo->query("SELECT cat_id FROM $this->db.rit_categorie WHERE cat_name = '$name'");
		$this->idCateg = $stmt->fetchColumn(0);
    }

    /**
     * @When I run the route to remove a categorie
     */
    public function iRunTheRouteToRemoveACategorie()
    {
		$ch = curl_init("http://localhost:8080/categ/remove/$this->idCateg");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have the categorie removed
     */
    public function iShouldHaveTheCategorieRemoved()
    {
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_categorie WHERE cat_id = $this->idCateg");
		PHPUnit_Framework_Assert::assertFalse((bool) $stmt->fetchColumn());		
    }

    /**
     * @Given a link to remove
     */
    public function aLinkToRemove()
    {
		$this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
		$url = "www.testRemoveExample.com";
		
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_url = '$url'");
		if(!(bool) $stmt->fetchColumn()){
			$stmt = $this->pdo->query("insert into $this->db.rit_link(lnk_url,lnk_status) values ('$url',1)");
		}
		
		$stmt = $this->pdo->query("SELECT lnk_id FROM $this->db.rit_link WHERE lnk_url = '$url'");
		$this->idLink =  $stmt->fetchColumn(0);
    }

    /**
     * @When I run the route to remove a link
     */
    public function iRunTheRouteToRemoveALink()
    {		
		$ch = curl_init("http://localhost:8080/link/remove/$this->idLink");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have the link removed
     */
    public function iShouldHaveTheLinkRemoved()
    {
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_id = $this->idLink");
		PHPUnit_Framework_Assert::assertFalse((bool) $stmt->fetchColumn());		
    }

    /**
     * @Given a link to archive
     */
    public function aLinkToArchive()
    {
		$this->pdo = new PDO("mysql:host=127.0.0.1", "rit_user", "a1z2e3r4");
		$url = "www.exampleArchived.com";
		
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_url = '$url'");
		if(!(bool) $stmt->fetchColumn()){
			$stmt = $this->pdo->query("insert into $this->db.rit_link(lnk_url,lnk_status) values ('$url',1)");
		}
		
		$stmt = $this->pdo->query("SELECT lnk_id FROM $this->db.rit_link WHERE lnk_url = '$url'");
		$this->idLink =  $stmt->fetchColumn(0);
    }

    /**
     * @When I run the route to archive a link
     */
    public function iRunTheRouteToArchiveALink()
    {
		$ch = curl_init("http://localhost:8080/link/archive/$this->idLink");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
    }

    /**
     * @Then I should have the link archived
     */
    public function iShouldHaveTheLinkArchived()
    {
		$stmt = $this->pdo->query("SELECT COUNT(*) FROM $this->db.rit_link WHERE lnk_id = $this->idLink and lnk_status=3");
		PHPUnit_Framework_Assert::assertTrue((bool) $stmt->fetchColumn());		
		
		$this->pdo->query("DELETE FROM $this->db.rit_link where lnk_id = $this->idLink");
    }
}
