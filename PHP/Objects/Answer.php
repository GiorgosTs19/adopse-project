<?php

class Answer 
    {
        public $ID;
        public $Text;
        public $Correct;
        public $ParentQuestion;
        
        function __construct($id, $text, $correct, $parentquestion) 
            {
                $this->ID = $id;
                $this->Text = $text;
                $this->Correct = $correct;
                $this->ParentQuestion = $parentquestion;
            }
            
        function getText()
            {
                return $this->Text;
            }
              
        function getID()
            {
                return $this->ID;
            }
            
        function isCorrect()
            {
                return $this->Correct;
            }
        
        function getParentQuestion()
            {
                return $this->ParentQuestion;
            }
            
        function setID($id)
            {
                $this->ID = $id;
            }
        function setText($text)
            {
                $this->Text = $text;
            }

        function setisCorrect($iscorrect)
            {
                $this->Correct = $iscorrect;
            }
            
        function setParentQuestion($parent)
            {
                $this->ParentQuestion = $parent;
            }
    }
