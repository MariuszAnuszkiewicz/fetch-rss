<?php

class InvalidUrl extends Exception {

    private $_invalid_url;

    public function getStatus() {

        return $this->_invalid_url;
    }

    public function setStatus($value) {

        $this->_invalid_url = $value;
    }

    public function checkUrl() {

        if ($this->getStatus() === true){

            throw new Exception("Invalid RSS feed URL.");
        }
        return;
    }
}
