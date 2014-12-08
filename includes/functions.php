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
    
    /*
     ** matching function that takes in an array of three crushes and returns an array
     ** of the ids of the crushes who are matches
     */ 
    function checkMatch($crushes)
    {
        // initializes array $matches which will ultimately contain the ids of any matches that we find
        $matches = [];
        
        // initializes counter to keep track of the number of elements in matches
        $counter = 0;
        
        // initializes three booleans to false that say if each of user's three crushes is a match 
        $crush1match = FALSE;
        $crush2match = FALSE;
        $crush3match = FALSE;
        
        // checks if crush1 has the user listed as one of his/her crushes
        if (checkExistence($crushes["crush1"]))
        {    
            // extract crush1's id and an array of his/her three crushes
            $crush1ID = query("SELECT id FROM users WHERE formattedname = ?", $crushes["crush1"]);
            $crushes1 = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $crush1ID[0]["id"]);
            
            // extract current user's formatted name
            $userArray = query("SELECT formattedname FROM users WHERE id = ?", $_SESSION["id"]); 
            $username = $userArray[0]["formattedname"];
            
            // compare crush1's crush1 with username to see if there is a match
            if (strcmp($username, $crushes1[0]["crush1"]) == 0)
            {
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $crush1ID[0]["id"]);
                $crush1match = TRUE;
            }
            
            // same as above but with crush1's crush2            
            if (strcmp($username, $crushes1[0]["crush2"]) == 0)
            {
               query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus2 = ? WHERE id = ?", TRUE, $crush1ID[0]["id"]);
                $crush1match = TRUE;
            }
            
            // same as above but with crush1's crush3            
            if (strcmp($username, $crushes1[0]["crush3"]) == 0)
            {
                query("UPDATE crushes SET matchstatus1 = ? WHERE id = ?", TRUE, $_SESSION["id"]);
                query("UPDATE crushes SET matchstatus3 = ? WHERE id = ?", TRUE, $crush1ID[0]["id"]);
                $crush1match = TRUE;
            }
            
            // adds crush1 to matches array if crush1 is a match
            if ($crush1match == TRUE)
            {
                $matches[$counter] = $crush1ID[0]["id"];
                $counter++;
            }
        }
        
        // checks if crush1 has the user listed as one of his/her crushes
        if (checkExistence($crushes["crush2"]))
        {    
            $crush2ID = query("SELECT id FROM users WHERE formattedname = ?", $crushes["crush2"]);
            $crushes2 = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $crush2ID[0]["id"]);
            
            $userArray = query("SELECT formattedname FROM users WHERE id = ?", $_SESSION["id"]); 
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
        
        // checks if crush1 has the user listed as one of his/her crushes
        if (checkExistence($crushes["crush3"]))
        {    
            $crush3ID = query("SELECT id FROM users WHERE formattedname = ?", $crushes["crush3"]);
            $crushes3 = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $crush3ID[0]["id"]);
            
            $userarray = query("SELECT formattedname FROM users WHERE id = ?", $_SESSION["id"]); 
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
        return $matches;   
    }
    
    // checks if user is in database and returns a boolean
    function checkExistence($user)
    {
        $userID = query("SELECT id FROM users WHERE formattedname = ?", $user);
        if (empty($userID))
        {
            return FALSE;
        }
        return TRUE;
    }
    
    // not sure if we want this. never gets called
    function createUserArray()
    {
        // array of all users ($users[i]["formattedname"];)
        $users = query("SELECT formattedname FROM users");        
        return $users;
    }
    
    // takes a first name and a last name and creates the formatted name ("first.last")
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
    
    // takes a formatted name and creates an unformatted name ("First Last")
    function unformatName($formattedname)
    {
        if ($formattedname == "")
        {
            return $formattedname;
        }
        
        // initialize unformatted name as copy of formatted name
        $unformatted = $formattedname;
        
        // capitalize the first letter
        $unformatted[0]= strtoupper($unformatted[0]);
        
        // iterate through the name
        for ($i = 0; $i < strlen($unformatted); $i++)
        {
            // replace the '.' with a space and capitalize the next letter
            if ($unformatted[$i] == '.')
            {
                $unformatted[$i] = ' ';
                $unformatted[$i+1] = strtoupper($unformatted[$i+1]);
            }
        }
        return $unformatted;
    }
    
    /*
     ** takes in a user id and creates an array of the times he/she is free, which is an array with 168 indices,
     ** one for each hour in a week, with true values for hours when the user is free and false values otherwise 
     */    
    function createTimeArray($userID)
    {
        // initially set all time slots to false
        $timesFree = array_fill(0, DAYS * HOURS, 0);
        
        // set all free times for the week
        $timesFree = insertFreeTime(SUNDAY, "sunStart", "sunEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(MONDAY, "monStart", "monEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(TUESDAY, "tuesStart", "tuesEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(WEDNESDAY, "wedStart", "wedEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(THURSDAY, "thursStart", "thursEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(FRIDAY, "friStart", "friEnd", $userID, $timesFree);
        $timesFree = insertFreeTime(SATURDAY, "satStart", "satEnd", $userID, $timesFree);
        
        return $timesFree;      
    }
    
    /* 
     ** gets the hours a user is free on a specific day from SQL and inserts a value of TRUE into 
     ** that user's timesFree array at indices where the user is free during the week
     */
    function insertFreeTime($day, $dayStart, $dayEnd, $userID, $timesFree)
    { 
        $availability = query("SELECT $dayStart, $dayEnd FROM times WHERE id = ?", $userID);
        
        // takes dayStart and dayEnd and converts them their corresponding hour in the week
        $startInt = ($day * HOURS) + $availability[0][$dayStart];
        $endInt = ($day * HOURS) + $availability[0][$dayEnd] - 1;
        
        if (($endInt % 24) != 0)
        {
            for ($i = $startInt; $i <= $endInt; $i++)
            {
                $timesFree[$i] = 1;
            }
        }

        return $timesFree;
    }
    
    // compares the arrays of times free for each person and returns an array of the hours that both of them are free   
    function findSharedFreeTimes($timesFree1, $timesFree2)
    {     
        $bothFree = [];
        $counter = 0;
        $timesLength = count($timesFree1);
        for ($i = 0; $i < $timesLength; $i++)
        {
            // if both are free, add to bothFree
            if ($timesFree1[$i] == 1 && $timesFree2[$i] == 1)
            {
                $bothFree[$counter] = $i;
                $counter++;
            }
        }
        return $bothFree;
    }
    
    // takes in an array of shared free times and returns an array of a day, time, and location for a date
    function setUpDate($sharedFreeTimes)
    {
        // the date will be the latest possible date that both are free in the week
        $highest = $sharedFreeTimes[count($sharedFreeTimes) - 1];
        $location = chooseLocation(modTime($highest));
        $dateTimeArray = intToDate($highest);
        $day = intToDay($dateTimeArray[0]);
        $time = intToFormattedTime($dateTimeArray[1]);

        return [$day, $time, $location]; 
    } 
    
    // takes in an int 0-167 (representing an hour in the week), and returns a corresponding day and time
    function intToDate($int)
    {
        $day = 0;
        while ($int > HOURS)
        {
            $int -= HOURS;
            $day++;
        }
        $time = $int;
        return [$day, $time]; 
    }
    
    // takes in an integer and returns a string of the day corresponding to the int
    function intToDay($int)
    {
        if ($int == 0)
        {
            return "SUNDAY";
        } 
        if ($int == 1)
        {
            return "MONDAY";
        }
        if ($int == 2)
        {
            return "TUESDAY";
        }
        if ($int == 3)
        {
            return "WEDNESDAY";
        }
        if ($int == 4)
        {
            return "THURSDAY";
        }
        if ($int == 5)
        {
            return "FRIDAY";
        }
        if ($int == 6)
        {
            return "SATURDAY";
        }
        
    }
    
    // takes in an integer and turns it into a well-formatted time (i.e. 17 to "5:00 PM")
    function intToFormattedTime($int)
    {
        if ($int > 12)
        {
            $int -= 12;
            $time = $int . ":00 PM";
            return $time;
        }
        else
        {
            $time = $int . ":00 AM";
            return $time;
        } 
    }
    
    // takes in int from 0-167 and returns int from 0-23
    function modTime($int)
    {
        $int = $int % HOURS;
        return $int;
    }
    
    // takes in the time the date will happen and accordingly chooses a location
    function chooseLocation($time)
    {
        // hardcoded in locations for dates in Harvard Square
        $breakfastLocations = ["STARBUCKS on Mass Ave", "ZOE'S", "ZINNEKEN'S"];
        $lunchLocations = ["OGGI'S", "FLAT PATTIES", "FELIPE'S"];
        $dinnerLocations = ["JOHN HARVARD'S BREWERY & ALE HOUSE", "BORDER CAFE", "SPICE", "FIRE & ICE"];
        if ($time > 0 && $time < 10)
        {
            $locationNum = rand(0, count($breakfastLocations) - 1);
            $location = $breakfastLocations[$locationNum];
        }
        else if ($time >= 10 && $time <= 16)
        {
            $locationNum = rand(0, count($lunchLocations) - 1);
            $location = $lunchLocations[$locationNum];
        }
        else
        {
            $locationNum = rand(0, count($dinnerLocations) - 1);
            $location = $dinnerLocations[$locationNum];
        }
        return $location;         
    }
    
    // takes in an id number and returns that user's email address
    function idToEmail($id)
    {
        $emailArray = query("SELECT email FROM users WHERE id = ?", $id);
        $email = $emailArray[0]["email"];
        return $email;
    }
    
    // takes in two email addresses of matches and sends an email notifying they have no times that match up
    function emailNoSharedTimes($address1, $address2)
    {
        require("PHPMailer-master/PHPMailerAutoload.php");
        require("PHPMailer-master/class.phpmailer.php"); 
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "mail.gmail.com";
        //$mail->SMTPDebug = 1; (use for debugging purposes)        
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = 'veritinder2@gmail.com';
        $mail->Password = 'dickle123';
        $mail->SetFrom('veritinder1@gmail.com', 'VeriTinder');
        $mail->AddReplyTo('veritinder1@gmail.com', 'VeriTinder');
        $mail->AddBCC($address1);
        $mail->AddBCC($address2);
        $mail->Subject = "New VeriTinder Match!";
        $mail->Body = "Congratulations on your match! Unfortunately we couldn't find a time that worked for both you and your match.
        
Please log back in and update your availability to make this work out. Once you update you will see another email.
       
Thank you!
                   
p.s. With any questions, just reply to this email and we'll get back to you.";
        
        if ($mail->Send() === false)
            die($mail->ErrorInfo . "\n");        
    }
    
    // takes in the emails of matches, along with info about their date, and sends an email to both users
    function emailMatches($address1, $address2, $day, $time, $location)
    {
        require("PHPMailer-master/PHPMailerAutoload.php");
        require("PHPMailer-master/class.phpmailer.php"); 
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "mail.gmail.com";
        //$mail->SMTPDebug = 1; (debugging purposes)       
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = 'veritinder1@gmail.com';
        $mail->Password = 'dickle123';
        $mail->SetFrom('veritinder1@gmail.com', 'VeriTinder');
        $mail->AddReplyTo('veritinder1@gmail.com', 'VeriTinder');
        $mail->AddBCC($address1);
        $mail->AddBCC($address2);
        $mail->Subject = "New VeriTinder Match!";
        $mail->Body = "Congratulations on your match!
                
Your date is on the next possible $day at $time! Meet at $location. Get pumped!
    
If you don't know how VeriTinder works, one of your crushes has liked you back! Here's the catch: we aren't telling you which one--you have to go and meet your crush in person. If today is $day, your meeting will occur next week on $day.
    
Please make sure to mention us in your wedding speech :)
    
p.s. With any questions, just reply to this email and we'll get back to you.";
        
        if ($mail->Send() === false)
            die($mail->ErrorInfo . "\n");
        
    }
?>
