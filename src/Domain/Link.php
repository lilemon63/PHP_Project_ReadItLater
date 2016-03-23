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
     * Link status.
     *
     * @var integer
     */
    private $status;

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
}
