<?php

class objChart {
    private $account;
    private $description;
    private $type_id;
    private $type;


    function getAccount() {
        return $this->account;
    }

    function getDescription() {
        return $this->description;
    }

    function getTypeId() {
        return $this->type_id;
    }

    function getType() {
        return $this->type;
    }
}

?>