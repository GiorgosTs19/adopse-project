<?php
class Quiz 
    {
        private $Title;
        private $ID;
        private $ShortDesc;
        private $Topic;
        //Συνολικό πλήθος ερωτήσεων
        private $QuestionCount;
        //Χρονικό όριο
        private $Timed;
        //Δεν επιτρέπεται πλοήγηση σε προηγούμενες ερωτήσεις
        private $ForwardOnly;
        //Αρνητική Βαθμολογία
        private $NegGrading;
        //Μόνο με κωδικό
        private $PassOnly;
        //Κωδικός για πρόσβαση μόνο με κωδικό (Null εκτός εάν το $PassOnly = true)
        private $Password;
        
        function hydrate($data)
            {
                foreach ($data as $attribut => $value) 
                {
                    $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
                    if (is_callable(array($this, $method))) 
                        {
                            $this->$method($value);
                        }
                }
            }
            
        function __construct($title, $shortdesc, $topic ,$questioncount, $id) 
            {
                $this->Title = $title;
                $this->ID = $id;
                $this->QuestionCount = $questioncount;
                $this->Topic = $topic;
                $this->ShortDesc = $shortdesc;
            }
        
        function getTitle()
            {
                return $this->Title;
            }
        function getID()
            {
                return $this->ID;
            }
        function getTopic()
            {
                return $this->Topic;
            }    
        function getShortDesc()
            {
                return $this->ShortDesc;
            }
        function isTimed()
            {
                return $this->Timed;
            }
        function isForwardOnly()
            {
                return $this->ForwardOnly;
            }
        function hasNegGrading()
            {
                return $this->NegGrading;
            }
        function isPassOnly()
            {
                return $this->PassOnly;
            }
        function getPass()
            {
                return $this->Password;
            }
        
        function setTitle($title)
            {
                return $this->Title = $title;
            }
        function setTopic($topic)
            {
                return $this->Topic = $topic;
            }    
        function setShortDesc($shortdesc)
            {
                return $this->ShortDesc = $shortdesc;
            }
        function setTimed($timed)
            {
                return $this->Timed = $timed;
            }
        function setForwardOnly($forwardonly)
            {
                return $this->ForwardOnly = $forwardonly;
            }
        function setNegGrading($netgrading)
            {
                return $this->NegGrading = $netgrading;
            }
        function setPassOnly($passonly)
            {
                return $this->PassOnly = $passonly;
            }
        function setPassword($password)
            {
                return $this->Password = $password;
            }       
    }
?>