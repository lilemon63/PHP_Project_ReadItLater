<?php

namespace RIT\DAO;

use Doctrine\DBAL\Connection;
use RIT\Domain\Link;

class LinkDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     *
     * @return array A list of all Links.
     */
    public function findAll() {
        $sql = "select * from rit_link";
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $links = array();
        foreach ($result as $row) {
            $linkId = $row['lnk_id'];
            $links[$linkId] = $this->buildLink($row);
        }
        return $links;
    }

    /**
     * Creates an Link object based on a DB row.
     *
     * @param array $row The DB row containing Link data.
     * @return \RIT\Domain\Link
     */
    private function buildLink(array $row) {
        $link = new Link();
        $link->setId($row['lnk_id']);
        $link->setUrl($row['lnk_url']);
        $link->setStatus($row['lnk_status']);
        return $link;
    }
}
