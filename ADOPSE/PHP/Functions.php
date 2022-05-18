<?php

function emailExists(String $email,String $genError) 
    {
        $GLOBALS['temp2'] = $email;

        try
            {
                $q = "SELECT 1 FROM users WHERE email=?";
                $stmt = $GLOBALS['conn']->prepare($q);
                $stmt->execute([$email]);
                $_SESSION['exec_reset'] = 0;
                $GLOBALS['temp3'] = 1;
                return $stmt->fetchColumn();

            } 
        catch (Exception $ex) {$genError = $ex;}
    }
    
function PasswordIsAuthenticated(String $password, $genError, String $email) 
    {
        try
            {
                $q = "SELECT password FROM users WHERE email=?";
                $stmt = $GLOBALS['conn']->prepare($q);
                $stmt->execute([$email]);
                $_SESSION['exec_reset'] = 0;
                $GLOBALS['temp3'] = 1;
                $temp = $stmt->fetchColumn();
                if(strcmp($password,$temp))
                    {
                        return false;
                    }
                else
                    {
                        return true;
                    }
            } 
        catch (Exception $ex) {$genError = $ex;}
    }
    
function selectMaxFromCreator($id,$table)
    {
        $q = "SELECT MAX(id) as mid FROM $table WHERE idcreator=? LIMIT 1";
            $stmt = $GLOBALS['conn']->prepare($q);
            $stmt->execute([$id]);
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            return $results["mid"];
    }

    
function selectQuestionAnswers($qid)
    {
        $q = "SELECT id, text, correct, parent FROM answers WHERE parent=?";
        $stmt = $GLOBALS['conn']->prepare($q);
        $stmt->execute([$qid]);
        $results = $stmt->fetchAll();
        return $results;
    }
?>


