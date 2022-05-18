<?php

class User
    {
        public $ID;
        public $Name;
        public $LastName;
        public $Email;
        
//        function __construct($id, $name, $lname, $email) 
//            {
//                $this->ID = $id;
//                $this->Name = $name;
//                $this->LastName = $lname;
//                $this->Email = $email;
//            }
            
        function getID()
            {
                return $this->ID;
            }
        function getName()
            {
                return $this->Name;
            }

        function getLastName()
            {
                return $this->LastName;
            }
        function getEmail()
            {
                return $this->Email;
            }
            
        function setID($id)
            {
                $this->ID = $id;
            }
        function setName($name)
            {
                $this->Name = $name;
            }
        function setLastName($last)
            {
                $this->LastName = $last;
            }
        function setEmail($email)
            {
                $this->Email = $email;
            }    
    }
