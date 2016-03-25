<?php

namespace RIT\DAO;

use Doctrine\DBAL\Connection;
use RIT\Domain\Categorie;

class CategorieDAO extends DAO
{
    /**
     * Return a list of all categories
     *
     * @return array A list of all categories for the article.
     */
    public function findAll() {
		$sql = "select * from rit_categorie";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $categories = array();
        foreach ($result as $row) {
            $categorieId = $row['cat_id'];
            $categories[$categorieId] = $this->buildDomainObject($row);
        }
        return $categories;
    }

    /**
     * Creates a Categorie object based on a DB row.
     *
     * @param array $row The DB row containing Categorie data.
     * @return \RIT\Domain\Categorie
     */
    protected function buildDomainObject(array $row) {
		$categorie = new Categorie();
        $categorie->setId($row['cat_id']);
        $categorie->setName($row['cat_name']);
        return $categorie;
    }
    
    /**
     * Returns a Categorie matching the supplied id.
     *
     * @param integer $id
     *
     * @return \RIT\Domain\Categorie|throws an exception if no matching article is found
     */
    public function find($id) {
        $sql = "select * from rit_categorie where cat_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No article matching id " . $id);
    }
    
        
    public function addCategorie($name){	
		$sql = "select COUNT(*) as a from rit_categorie where cat_name=?";
        $result = $this->getDb()->fetchAll($sql,array($name));
        if($result[0]['a'] == "1"){
			return "1";
		}
		
		$this->getDb()->insert('rit_categorie',array('cat_name' => $name));
		return "0";
	}
	
    public function changeCategorie($idLink, $idCateg){	
		
		$this->getDb()->update('rit_link', 
					array(	'cat_id' => $idCateg )
					, array('lnk_id' => $idLink)); // where lnk_id = $id
		
		return "0";
	}
	
    public function removeCategorie($id){
		try{
			$this->find($id);
		}
		catch(Exception $e){
			return "1";
		}
		$this->getDb()->update('rit_link',
				array( 'cat_id' => null),
				array( 'cat_id' => $id));
        
        $this->getDb()->delete('rit_categorie',array('cat_id' => $id));
        return "0";
	}
}
