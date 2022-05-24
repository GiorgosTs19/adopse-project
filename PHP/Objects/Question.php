<?php

class Question 
    {
        public $ID;
        public $Text;
        public $Type;
        public $Topic;
        public $CreatorID;
        
        function __construct($id, $text, $type, $topic, $idcreator) 
            {
                $this->ID = $id;
                $this->Text = $text;
                $this->Type = $type;
                $this->Topic = $topic;
                $this->CreatorID = $idcreator;
            }


        function getID()
            {
                return $this->ID;
            }
        function getText()
            {
                return $this->Text;
            }

        function getType($condition)
            {
                if(strcmp($condition, "full"))
                    {
                        if(strcmp($this->Type, "MCSCA"))
                            {
                                return "Multiple Choice with a Single Answer";
                            }
                        else if(strcmp($this->Type, "MCMCA"))
                            {
                                return "Multiple Choice Multiple Correct Answers";
                            }
                        else if(strcmp($this->Type, "ToF"))
                            {
                                return "True or False";
                            }
                        else if (strcmp($this->Type, "PT"))
                            {
                                return "Plain Text";
                            }
                    }
                else
                    {
                        return $this->Type;
                    }
                
            }
            
        function getTopic()
            {
                return $this->Topic;
            }
            
        function getCreator()
            {
                return $this->CreatorID;
            }
            
        function setID($id)
            {
                $this->ID = $id;
            }
        function setText($text)
            {
                $this->Text = $text;
            }

        function setType($type)
            {
                $this->Type = $type;
            }
            
        function setTopic($topic)
            {
                $this->Topic = $topic;
            }
            
        function setCreator($creatorid)
            {
                $this->CreatorID = $creatorid;
            }
            
        function fetchAnswers()
            {
                
            }
        
    }
