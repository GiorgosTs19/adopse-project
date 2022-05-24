<?php
function Timed($condition, $time)
    {
        if($condition==0)
            {
                return "No Time Limit.";
            }
        else
            {
                return "Time Limit : " . $time . " minutes.";
            }
    }

function isTimed($quizid)
    {
        $selectTimed = "SELECT timed  FROM quizattributes WHERE quizid=?;";
        $stmt2 = $GLOBALS['conn']->prepare($selectTimed);
        $stmt2->execute([$quizid]);
        $isTimed = $stmt2->fetch(PDO::FETCH_ASSOC);
        return $isTimed['timed'];
    }

function MultipleAttempts($condition, $attempts)
    {
        if($condition==0)
            {
                return "Only 1 attempt is allowed.";
            }
        else if ($condition==1 && $attempts==10000)
            {
                return "No attempt limit.";
            }
        else
            {
                return "Attempt limit : " . $attempts . ".";
            }
    }

function Shuffled($condition)
    {
        if($condition==0)
            {
                return "";
            }
        else
            {
                return "Random Question Order.";
            }
    }

function ForwardOnly($condition)
    {
        if(!$condition==0)
            {
                return "Forward Only.";
            }
        else
            {
                return "Question Navigation Allowed.";
            }
    }

function NegativeGrading($condition)
    {
        if($condition==0)
            {
                return "There is no Negative Grading.";
            }
        else
            {
                return "Negative Grading is active.";
            }
    }

function PasswordOnly($condition)
    {
        if($condition==0)
            {
                return "";
            }
        else
            {
                return "This quiz is accessible only with a password.";
            }
    }

function Editable($creatorid, $userid, $quizid)
    {
        if($creatorid==$userid)
            {
                return "<img class='editbutton' src='../images/edit_icon.png' onclick='editThisQuiz($quizid)'style='width: 40px;height: 40px;'>";
            }
        else{
            {
                return "";
            }
        }
    }
function Favorite($isfavorite, $quizid)
    {
        if (!$isfavorite)
            {
                return
                    '<div id="FUSubmitButton'.$quizid.'">
                        <input type="image" id="favThisQuiz'.$quizid.'" class="editbutton" src="../images/favorite_empty.png" 
                        onclick="favThisQuiz('.$quizid.')" style="width: 40px;height: 40px;">
                    </div>';

            }
        else

            {
                return
                    '<div id="FUSubmitButton'.$quizid.'">
                        <input type="image" id="unFavThisQuiz'.$quizid.'" class="editbutton" src="../images/favorite_filled.png" 
                        onclick="unFavThisQuiz('.$quizid.')" style="width: 40px;height: 40px;">
                    </div>';
            }
    }

function setStartButton($quizid)
    {
        return  '<a href="http://localhost/ADOPSE/PHP/startQuiz.php?sqid='.$quizid.'">
        <img class="editbutton" src="../images/start_quiz_button.png" style="width: 40px; height: 40px;">
        </a>';
    }

function isFavorite($userid, $quizid)
    {
        $select = "	SELECT * FROM favorites WHERE userid=? && quizid=?;";
        $stmt1 = $GLOBALS['conn']->prepare($select);
        $stmt1->execute([$userid,$quizid]);
        $result = $stmt1->fetch(PDO::FETCH_COLUMN, 0);
        return $result;
    }

function userAllowedAttempts($quizid)
    {
        $selectattempts = "SELECT attempts FROM quizattributes WHERE quizid=?;";
        $stmt1 = $GLOBALS['conn']->prepare($selectattempts);
        $stmt1->execute([$quizid]);
        $attemptsallowed = $stmt1->fetch(PDO::FETCH_ASSOC);

        $selectattemptsdone = "SELECT COUNT(*) AS attemptsdone FROM attempts WHERE quizid=? AND userid=?;";
        $stmt2 = $GLOBALS['conn']->prepare($selectattemptsdone);
        $stmt2->execute([$quizid, $_SESSION['UserId']]);
        $attemptsdone = $stmt2->fetch(PDO::FETCH_ASSOC);

        $attemptsleft = $attemptsallowed['attempts'] - $attemptsdone['attemptsdone'];

        if ($attemptsallowed['attempts']==10000)
            {
                return "There is no attempt limit.";
            }
        else if($attemptsleft>0)
            {
                return "Allowed Attempts Remaining : ".$attemptsleft;
            }
        else
            {
                return "You are not allowed any more attempts.";
            }
    }

function answerIsSet($attemptid, $userid, $quizid, $questionid, $answerid, $selection)
    {
        if(!strcmp($selection, "Multiple"))
            {
                if(empty($answerid))
                    {
                        $q1 = "SELECT * 
                        FROM attemptanswers 
                        WHERE attemptid = ? 
                        AND userid = ? AND 
                        quizid=? AND questionid=?";

                        $stmt1 = $GLOBALS['conn']->prepare($q1);
                        $stmt1->execute([$attemptid, $userid, $quizid, $questionid]);
                        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                        return $result;
                    }
                else
                    {
                        $q1 = "SELECT * 
                        FROM attemptanswers 
                        WHERE attemptid = ? 
                        AND userid = ? AND 
                        quizid=? AND questionid=? AND answerid=?";

                        $stmt1 = $GLOBALS['conn']->prepare($q1);
                        $stmt1->execute([$attemptid, $userid, $quizid, $questionid, $answerid]);
                        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                        return $result;
                    }

            }
        else if(!strcmp($selection, "Single"))
            {
                $q1 = "SELECT * 
                    FROM attemptanswers 
                    WHERE attemptid = ? 
                    AND userid = ? AND 
                    quizid=? AND questionid=?";

                $stmt1 = $GLOBALS['conn']->prepare($q1);
                $stmt1->execute([$attemptid, $userid, $quizid, $questionid]);
                $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
    }

function returnAnswerType($questionid, $type, $text, $answerid, $attempid, $userid, $quizid)
    {
        if($type=="ToF")
            {
                if(answerIsSet($attempid, $userid, $quizid, $questionid, $answerid, "Single"))
                    {
                        $result = answerIsSet($attempid, $userid, $quizid, $questionid, $answerid, "Single");
                        if((int)$result['answerid']===(int)$answerid)
                            {
                                echo        '<input checked type="radio" name="answer" value="'.$answerid.'">';
                                echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                            }
                        else
                            {
                                echo        '<input type="radio" name="answer" value="'.$answerid.'">';
                                echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                            }
                    }
                else
                    {
                        echo        '<input type="radio" name="answer" value="'.$answerid.'">';
                        echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                    }
            }
        else if($type=="MCSCA")
            {
                if(answerIsSet($attempid, $userid, $quizid, $questionid, $answerid, "Single"))
                    {
                        $result = answerIsSet($attempid, $userid, $quizid, $questionid, $answerid, "Single");
                        if((int)$result['answerid']===(int)$answerid)
                            {
                                echo        '<input checked type="radio" name="answer" value="'.$answerid.'">';
                                echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                            }
                        else
                            {
                                echo        '<input type="radio" name="answer" value="'.$answerid.'">';
                                echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                            }
                    }
                else
                    {
                        echo        '<input type="radio" name="answer" value="'.$answerid.'">';
                        echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                    }
            }
        else if($type=="MCMCA")
            {
                if(answerIsSet($attempid, $userid, $quizid, $questionid, $answerid, "Multiple"))
                    {
                        echo        '<input checked type="checkbox" name="canswer[]" value="'.$answerid.'">';
                        echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                    }
                else
                    {
                        echo        '<input type="checkbox" name="canswer[]" value="'.$answerid.'">';
                        echo        '<label for="answer'.$questionid.'">'.$text.'</label>';
                    }
            }

    }

function getQuizQuestions($quizid)
    {
        $q2 = "select questionid from quizquestions where quizid= ?";

        $stmt2 = $GLOBALS['conn']->prepare($q2);
        $stmt2->execute([$quizid]);
        $answers = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);
        return $answers;
    }

function countQuestions($id)
    {
        $q2 = "select count(questionid) as count from quizquestions where quizid= ?";

        $stmt2 = $GLOBALS['conn']->prepare($q2);
        $stmt2->execute([$id]);
        $answers = $stmt2->fetch(PDO::FETCH_ASSOC);
        return $answers['count'];
    }

function getPreviousAndNextQuestionIDs($quizid, $currentquestionid)
    {
        $questions=getQuizQuestions($quizid);
        $index=array_search((int)$currentquestionid,$questions,true);

        if($index!=0 && $index!=array_key_last($questions))
            {
                $prev = $index-1;
                $next = $index+1;
                return array($questions[$prev],$currentquestionid,$questions[$next]);
            }
        else if ($index==array_key_last($questions))
            {
                $prev = $index-1;
                return array($questions[$prev],$currentquestionid,null);
            }
        else if($index==0)
            {
                $next = $index+1;
                return array(null,$currentquestionid,$questions[$next]);
            }
    }

function getQuestion($questionid)
    {
        $q1 =   "SELECT *
            FROM questions
            WHERE id=?;";

        $stmt1 = $GLOBALS['conn']->prepare($q1);
        $stmt1->execute([$questionid]);
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

function getLastAttemptonQuizID($quizid,$userid)
    {
        $q4 = "SELECT MAX(attemptid) AS attemptid FROM attempts WHERE quizid=? AND userid=?";

        $stmt4 = $GLOBALS['conn']->prepare($q4);
        $stmt4->execute([$quizid,$userid]);
        return $stmt4->fetch(PDO::FETCH_ASSOC);
    }

function deleteAnswerUpdate($attemptid, $userid, $quizid, $questionid, $answers)
    {
        $intAnswers = array_map(
            function($value) { return (int)$value; },
            $answers
        );
                $q1 = "SELECT answerid
                FROM attemptanswers
                WHERE attemptid = ?
                AND userid = ? AND
                quizid=? AND questionid=? ;";

                $stmt1 = $GLOBALS['conn']->prepare($q1);
                $stmt1->execute([$attemptid, $userid, $quizid, $questionid]);
                $result = $stmt1->fetchAll(PDO::FETCH_COLUMN, 0);

                $toDelete = array_diff($result,$intAnswers);

                foreach ($toDelete as $deleteid)
                    {

                        $q1 = "DELETE FROM attemptanswers
                        WHERE attemptid = ?
                        AND userid = ? AND
                        quizid=? AND questionid=? AND answerid=?;";

                        $stmt1 = $GLOBALS['conn']->prepare($q1);
                        $stmt1->execute([$attemptid, $userid, $quizid, $questionid, $deleteid]);
                    }

    }

function deleteNulls($attemptid, $userid, $quizid, $questionid)
    {
        $q1 = "DELETE FROM attemptanswers 
        WHERE attemptid = ? 
        AND userid = ? AND 
        quizid=? AND questionid=? AND isnull(answerid);";

        $stmt1 = $GLOBALS['conn']->prepare($q1);
        $stmt1->execute([$attemptid, $userid, $quizid, $questionid]);
    }

function answerSubmitted($attemptid, $userid, $quizid, $questionid)
    {
        $q1 = "SELECT * 
                FROM attemptanswers 
                WHERE attemptid = ? 
                AND userid = ? AND 
                quizid=? AND questionid=?";

        $stmt1 = $GLOBALS['conn']->prepare($q1);
        $stmt1->execute([$attemptid, $userid, $quizid, $questionid]);
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

function gradeQuestion($questionid, $answergivenid, $quizid)
    {
        $question = getQuestion($questionid);
        $grade = getCorrectAnswerGrade($quizid);
        $neggrade = getNegGrading($quizid);

        if(!strcmp($question['type'],"ToF") || !strcmp($question['type'],"MCSCA") )
            {
                $correctanswer = getCorrectAnswers($questionid, "Single");
                if((int)$answergivenid===(int)$correctanswer)
                    {
                        return (double)$grade;
                    }
                else if((int)$answergivenid!=(int)$correctanswer)
                    {
                        if($neggrade==0)
                            {
                                return 0;
                            }
                        else
                            {
                                $final = -$grade/$neggrade;
                                return (double)$final;
                            }
                    }
            }
        else if (!strcmp($question['type'],"MCMCA"))
            {
                $correctanswers = getCorrectAnswers($questionid, "Multiple");
                $intAnswers = array_map(
                    function($value) { return (int)$value; },
                    $correctanswers
                );

                $wronganswers = array_diff($correctanswers,$intAnswers);
                $i=0;
                foreach ($wronganswers as $wrong)
                    {
                        $i++;
                    }
                if($neggrade==0)
                    {
                        return 0;
                    }
                else
                    {
                        if($i===0)
                            {
                                return (double)$grade;
                            }
                        else
                            {
                                $final = -($grade/$neggrade)*$i;
                                return (double)$final;
                            }
                    }
            }
    }

 function getNegGrading($quizid)
     {
         $q1 = "select negativegrading
                from quizattributes
                where quizid = ? ;";

         $stmt1 = $GLOBALS['conn']->prepare($q1);
         $stmt1->execute([$quizid]);
         $result = $stmt1->fetch(PDO::FETCH_ASSOC);
         $neg= $result['negativegrading'];

         if((int)$neg===0)
             {
                 return 0;
             }
         else
             {
                 $q2 = "select neggrade
                from quizattributes
                where quizid = ? ;";

                 $stmt2 = $GLOBALS['conn']->prepare($q2);
                 $stmt2->execute([$quizid]);
                 $result2 = $stmt1->fetch(PDO::FETCH_ASSOC);
                 $neggrade= $result2['neggrade'];
                 return $neggrade;
             }
     }

function getCorrectAnswerGrade($quizid)
    {
        (int)$count = countQuestions($quizid);
        (double)$correctanswergrade = 100/$count;
        return $correctanswergrade;
    }

function getCorrectAnswers($questionid, $selection)
    {
        if(!strcmp($selection,"Single"))
            {
                $q1 = "select a.id as correctAnswerId
                from questions as q 
                join answers as a 
                on q.id = a.parent 
                where q.id = ? and correct = 1; ";

                $stmt1 = $GLOBALS['conn']->prepare($q1);
                $stmt1->execute([$questionid]);
                $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
        else
            {
                $q1 = "select a.id as correctAnswerId
                from questions as q 
                join answers as a 
                on q.id = a.parent 
                where q.id = ? and correct = 1; ";

                $stmt1 = $GLOBALS['conn']->prepare($q1);
                $stmt1->execute([$questionid]);
                $result = $stmt1->fetchAll();
                return $result;
            }
    }
?>
