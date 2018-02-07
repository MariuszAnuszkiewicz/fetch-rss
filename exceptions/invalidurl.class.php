<?php

class InvalidUrlException extends Exception {}

class InvalidUrl {

    private $_invalid_url;

    public function getStatus() {

        return $this->_invalid_url;
    }

    public function setStatus($value) {

        $this->_invalid_url = $value;
    }

    public function checkUrl() {

        if ($this->getStatus() === true){

            throw new InvalidUrlException("Invalid RSS feed URL.");
        }
        return;
    }
}
