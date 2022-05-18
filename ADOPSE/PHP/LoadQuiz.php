<?php

class LoadQuiz 
    {
        private $LegendTag;
        private $TitleTag;
        private $Quiz;
        private $SDescTag;
        private $QuizID;
        private $TopicTag;
        
        function __construct($quiz) 
            {
               $Quiz = $quiz;
               $this->QuizID = $Quiz->getID();           
            }
            
        function BuildInfoTags($container)
            {
                $this->LegendTag = new HTMLElement('legend');
                $this->LegendTag->set('id', "Legend$QuizID");        
                        
                $this->TitleTag = new HTMLElement('h2');
                $temp = $Quiz->getTitle();
                $this->TitleTag->set('value', $temp);
                $this->TitleTag->set('id', "Title$QuizID");
                //$this->LegendTag
                
                $this->TopicTag = new HTMLElement('p');
                $temp = $Quiz->getTopic();
                $this->TitleTag->set('value',"Topic : $temp");
                $this->TitleTag->set('id', "Title$QuizID");
                
                $this->SDescTag = new HTMLElement('h1');
                $temp = $Quiz->getTitle();
                $this->TitleTag->set('value', $temp);
                $this->TitleTag->set('id', "SDesc$QuizID");
                
                $this->TitleTag = new HTMLElement('h1');
                $temp = $Quiz->getTitle();
                $this->TitleTag->set('value', $temp);
                $this->TitleTag->set('id', "Title$QuizID");
                
            }
    }
?>

