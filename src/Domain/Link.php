<?php

namespace RIT\Domain;

class Link
{
    /**
     * Link id.
     *
     * @var integer
     */
    private $id;

    /**
     * Link url
     *
     * @var string
     */
    private $url;

    /**
     * Link status
     *
     * @var integer
     */
    private $status;    
    
    /**
     * Link content
     *
     * @var string
     */
    private $content;
    
    
    /**
     * Associated categorie.
     *
     * @var \RIT\Domain\Categorie
     */
    private $categorie;


    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }
    
    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie) {
        $this->categorie = $categorie;
    }
}
