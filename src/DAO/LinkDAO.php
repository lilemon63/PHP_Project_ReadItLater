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

    public function findAllWithContent() {
        $sql = "select * from rit_link where rit_status = 2";
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
        $sql = "select * from rit_link where rit_status = 3";
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
        $sql = "select lnk_id,lnk_url,lnk_status from rit_link where cat_id=?";
        
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
}
