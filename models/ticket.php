<?php

class Ticket {
    private $id;//number of the ticket in DB
    private $category;//category id
    private $user_id;//existing user_id
    private $openDate;//Opening date of ticket
    private $closeDate;//Closing Date of ticket
    private $priority;//Priority level
    private $message;//message from user
    

    //GET/SET TICKET ID
    public function getId() {
        return $this->id;
    }
    public function setId($param) {
        $this->id = $param;
    }
    //GET/SET TICKET CATEGORY TOPIC
    public function getCategory() {
        return $this->category;
    }
    public function setCategory($param) {
        $this->category = $param;
    }
    //GET/SET TICKET CATEGORY ORIGINAL USER
    public function getUserId() {
        return $this->user_id;
    }
    public function setUserId($param) {
        $this->user_id = $param;
    }
    //GET/SET TICKET CATEGORY OPENING DATE
    public function getOpenDate() {
        return $this->openDate;
    }
    public function setOpenDate($param) {
        $this->openDate = $param;
    }
    //GET/SET TICKET CATEGORY CLOSING DATE
    public function getCloseDate() {
        return $this->closeDate;
    }
    public function setCloseDate($param) {
        $this->closeDate = $param;
    }
    //GET/SET TICKET PRIORITY
    public function getPriority() {
        return $this->priority;
    }
    public function setPriority($param) {
        $this->priority = $param;
    }
    //GET/SET TICKET MESSAGE
    public function getMessage() {
        return $this->message;
    }
    public function setMessage($param) {
        $this->message = $param;
    }

    //CREATE NEW TICKET WITH USER, OPEN DATE AND CATEGORY
    public function  __construct($user, $openDate, $category, $message = "") {
        $this->setUserId($user);
        $this->setOpenDate($openDate);
        $this->setCategory($category);
        $this->setMessage($message);
    }

};//End Ticket Class


?>