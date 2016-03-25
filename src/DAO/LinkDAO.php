<?php

namespace RIT\DAO;

use Doctrine\DBAL\Connection;
use RIT\Domain\Link;

class LinkDAO extends DAO
{
	private $categorieDAO;
	
	public function setCategorieDAO(CategorieDAO $categorieDAO){
		$this->categorieDAO = $categorieDAO;
	}
	
    /**
     *
     * @return array A list of all Links.
     */
    public function findAll() {
        $sql = "select * from rit_link";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row) {
            $linkId = $row['lnk_id'];
            $links[$linkId] = $this->buildDomainObject($row);
        }
        return $links;
    }
    
    public function find($id) {
        $sql = "select * from rit_link where lnk_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching id " . $id);
    }

    public function findAllWithContent() {
        $sql = "select * from rit_link where lnk_status = 2";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row) {
            $linkId = $row['lnk_id'];
            $links[$linkId] = $this->buildDomainObject($row);
        }
        return $links;
    }

    public function findAllArchived() {
        $sql = "select * from rit_link where lnk_status = 3";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row) {
            $linkId = $row['lnk_id'];
            $links[$linkId] = $this->buildDomainObject($row);
        }
        return $links;
    }

    /**
     *
     * @return array A list of all Links.
     */
    public function findAllByCategorie($categorieId) {
		
		$categ = $this->categorieDAO->find($categorieId);
        $sql = "select * from rit_link where cat_id=?";
        
        $result = $this->getDb()->fetchAll($sql,array($categorieId));
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row) {
            $linkId = $row['lnk_id'];
            $link = $this->buildDomainObject($row);
            $link->setCategorie($categ);
            $links[$linkId] = $link;
            
        }
        return $links;
    }
    

    /**
     * Creates an Link object based on a DB row.
     *
     * @param array $row The DB row containing Link data.
     * @return \RIT\Domain\Link
     */
    protected function buildDomainObject(array $row) {
        $link = new Link();
        $link->setId($row['lnk_id']);
        $link->setUrl($row['lnk_url']);
        $link->setStatus($row['lnk_status']);
        
        $link->setContent($row['lnk_content']);
        $link->setTitle($row['lnk_title']);
        return $link;
    }
    
    public function addLink($url){
		
		$sql = "select COUNT(*) as a from rit_link where lnk_url=?";
        $result = $this->getDb()->fetchAll($sql,array($url));
        if($result[0]['a'] == "1"){
			return "1";
		}
		
		$this->getDb()->insert('rit_link',array('lnk_url' => $url, 'lnk_status' => 1,'lnk_content' => ''));
		return "0";
	}
	
	public function searchContent($id){
		$sql = "select * from rit_link where lnk_id=?";
		$result = $this->getDb()->fetchAll($sql,array($id));
		
        foreach ($result as $row) {
			$linkId = $row['lnk_id'];
            $link = $this->buildDomainObject($row);
            
			$this->parse_content_data($link);
			$link->setStatus(2);
			
			$this->updateObject($link);
			
		}
	}
	
	public function updateObject($link){
		
		$this->getDb()->update('rit_link', 
					array(	'lnk_url' => $link->getUrl(), 
							'lnk_status' => $link->getStatus(), 
							'lnk_content' => $link->getContent(),
							'lnk_title' => $link->getTitle())
					, array('lnk_id' => $link->getId())); // where lnk_id = $id
	}
	
	
	function get_remote_data($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$data = curl_exec($ch);
		curl_close($ch);



		return $data;
	}

	public function parse_content_data($link){

		$html = $this->get_remote_data($link->getUrl());

		$doc = new \DOMDocument();
		@$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('title');

		$title = $nodes->item(0)->nodeValue;


		$texts = $doc->getElementsByTagName('p');
		
		$content = '';
		for ($i = 0; $i < $texts->length; $i++)
		{
			$text = $texts->item($i);
			
			if(null !== $text->getAttribute('textContent'))
				$content .= $text->textContent . '<br/>';
		}
		
		if(isset($title)){
			$link->setTitle($title);
		}
		if(isset($content)){
			$link->setContent($content);
		}
	}
}
