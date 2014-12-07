<?php

    /**
     * functions.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Helper functions.
     */

    require_once("constants.php");

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
        exit;
    }

    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("../templates/header.php");

            // render template
            require("../templates/$template");

            // render footer
            require("../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }
    
    // matching function
    function checkMatch($crushes)
    {
        $matches = [];
        $counter = 0;
        //dump($crushes["crush1"]);
        $crush1match = FALSE;
        $crush2match = FALSE;
        $crush3match = FALSE;
        //dump(checkExistence($crushes[0]["crush1"]));
        if (checkExistence($crushes["crush1"]))
        {    
            $crush1ID = query("SELECT id FROM users WHERE formattedname = ?", $crushes["crush1"]);
            $crushes1 = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $crush1ID[0]["id"]);
            $userArray = query("SELECT formattedname FROM users WHERE id = ?", $_SESSION["id"]); 
            //dump($username);
            $username = $userArray[0]["formattedname"];
            if (strcmp($username, $crushes1[0]["crush1"]) == 0)
            {
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $crush1ID[0]["id"]);
                $crush1match = TRUE;
            }            
            if (strcmp($username, $crushes1[0]["crush2"]) == 0)
            {
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $crush1ID[0]["id"]);
                $crush1match = TRUE;
            }
            if (strcmp($username, $crushes1[0]["crush3"]) == 0)
            {
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $crush1ID[0]["id"]);
                $crush1match = TRUE;
            }
            if ($crush1match == TRUE)
            {
                $matches[$counter] = $crush1ID[0]["id"];
                $counter++;
            }
        } 
        if (checkExistence($crushes["crush2"]))
        {    
            $crush2ID = query("SELECT id FROM users WHERE formattedname = ?", $crushes["crush2"]);
            //dump($crush2ID);
            $crushes2 = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $crush2ID[0]["id"]);
            $userArray = query("SELECT formattedname FROM users WHERE id = ?", $_SESSION["id"]); 
            //dump($username);
            $username = $userArray[0]["formattedname"];
            if (strcmp($username, $crushes2[0]["crush1"]) == 0)
            {
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $crush2ID[0]["id"]);
                $crush2match = TRUE;
            }            
            if (strcmp($username, $crushes2[0]["crush2"]) == 0)
            {
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $crush2ID[0]["id"]);
                $crush2match = TRUE;
            }
            if (strcmp($username, $crushes2[0]["crush3"]) == 0)
            {
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $crush2ID[0]["id"]);
                $crush2match = TRUE;
            }
            if ($crush2match == TRUE)
            {
                $matches[$counter] = $crush2ID[0]["id"];
                $counter++;
            }
        } 
        if (checkExistence($crushes["crush3"]))
        {    
            $crush3ID = query("SELECT id FROM users WHERE formattedname = ?", $crushes["crush3"]);
            $crushes3 = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $crush3ID[0]["id"]);
            $userarray = query("SELECT formattedname FROM users WHERE id = ?", $_SESSION["id"]); 
            //dump($username);
            $username = $userarray[0]["formattedname"];
            if (strcmp($username, $crushes3[0]["crush1"])==0)
            {
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $crush3ID[0]["id"]);
                $crush3match = TRUE;
            }            
            if (strcmp($username, $crushes3[0]["crush2"])==0)
            {
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $crush3ID[0]["id"]);
                $crush3match = TRUE;
            }
            if (strcmp($username, $crushes3[0]["crush3"])==0)
            {
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $crush3ID[0]["id"]);
                $crush3match = TRUE;
            }
            if ($crush3match == TRUE)
            {
                $matches[$counter] = $crush3ID[0]["id"];
                $counter++;
            }
        } 
        //dump($matches);   
        return $matches;   
    }
    
    function checkExistence($user)
    {
        $userID = query("SELECT id FROM users WHERE formattedname = ?", $user);
       // dump($userID);
        if (empty($userID))
        {
            return FALSE;
        }
        return TRUE;
    }
    
    function createUserArray()
    {
        // array of all users ($users[i]["formattedname"];)
        $users = query("SELECT formattedname FROM users");        
        return $users;
    }
    
    function formatName($first, $last)
    {
        if (!empty($first) && !empty($last))
        {
            $formattedname = strtolower($first) . "." . strtolower($last);
        }
        else
        {
            $formattedname = "";
        }
        return $formattedname;
    }
    
    function unformatName($formattedname)
    {
        if ($formattedname == "")
        {
            return $formattedname;
        }
        $unformatted = $formattedname;
        $unformatted[0]= strtoupper($unformatted[0]);
        for ($i = 0; $i < strlen($unformatted); $i++)
        {
            if ($unformatted[$i] == '.')
            {
                $unformatted[$i] = ' ';
                $unformatted[$i+1] = strtoupper($unformatted[$i+1]);
            }
        }
        return $unformatted;
    }
    
        
    function createTimeArray($userID)
    {
        // initially set all time slots to false
        $timesFree = array_fill(0, DAYS * HOURS, 0);
        //dump($timesFree);
        /*for ($i = 0; $n = count($timesFree), $i < $n; $i++)
        {
            $timesFree[$i] = FALSE;
        }*/
        
        // set all free times for the week
        $timesFree = insertFreeTime(SUNDAY, "sunStart", "sunEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(MONDAY, "monStart", "monEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(TUESDAY, "tuesStart", "tuesEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(WEDNESDAY, "wedStart", "wedEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(THURSDAY, "thursStart", "thursEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(FRIDAY, "friStart", "friEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(SATURDAY, "satStart", "satEnd", $userID, $timesFree);
        //dump($timesFree);
        return $timesFree;
        //dump($availability0);
        
    }
    
    // get free hours for one day from SQL and change array to TRUE accordingly
    function insertFreeTime($day, $dayStart, $dayEnd, $userID, $timesFree)
    { 
        $availability = query("SELECT $dayStart, $dayEnd FROM times WHERE id = ?", $userID);
        $startInt = ($day * HOURS) + $availability[0][$dayStart];
        $endInt = ($day * HOURS) + $availability[0][$dayEnd];

        if (($endInt % 24) != 0)
        {
            for ($i = $startInt; $i <= $endInt; $i++)
            {
                $timesFree[$i] = 1;
            }
        }

        return $timesFree;
    }
    
        
        
   function findSharedFreeTimes($timesFree1, $timesFree2)
   {     
        $bothFree = [];
        $counter = 0;
        $timesLength = count($timesFree1);
        for ($i = 0; $i < $timesLength; $i++)
        {
            if ($timesFree1[$i] == 1 && $timesFree2[$i] == 1)
            {
                $bothFree[$counter] = $i;
                $counter++;
            }
        }
        dump($bothFree);
        return $bothFree;
   }
    
    function emailMatches($address1, $address2)
    {
        require("PHPMailer-master/PHPMailerAutoload.php");
        require("PHPMailer-master/class.phpmailer.php"); 
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "mail.gmail.com";
        $mail->SMTPDebug = 1;
        
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 456;
        $mail->Username = 'veritinder@gmail.com';
        $mail->Password = 'dickle123';
        $mail->SetFrom('veritinder@gmail.com', 'VeriTinder');
        $mail->AddReplyTo('veritinder@gmail.com', 'VeriTinder');
        $mail->AddAddress($address1);
        $mail->AddAddress($address2);
        $mail->Subject = "New VeriTinder Match!";
        $mail->Body = "You have a match!";
        
        if ($mail->Send() === false)
            die($mail->ErrorInfo . "\n");
        
    }
    
    /*function undoTime($int)
    {
        $day;
        $hour;
        while ($int > 23)
        {
           $int -= 24;
           $day++;
        }
        $hour = $int;
        
        $return {$hour, $day}; 
    }*/

?>
