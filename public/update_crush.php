<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("update_crush_form.php", ["title" => "Update crushes!"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // only accepts full names
        if ((!empty($_POST["crushfirst1"]) && empty($_POST["crushlast1"]))
            || (empty($_POST["crushfirst1"]) && !empty($_POST["crushlast1"])))
        {
            apologize("Please fill out full name for crush #1!");
        }
        if ((!empty($_POST["crushfirst2"]) && empty($_POST["crushlast2"]))
            || (empty($_POST["crushfirst2"]) && !empty($_POST["crushlast2"])))
        {
            apologize("Please fill out full name for crush #2!");
        }
        if ((!empty($_POST["crushfirst3"]) && empty($_POST["crushlast3"]))
            || (empty($_POST["crushfirst3"]) && !empty($_POST["crushlast3"])))
        {
            apologize("Please fill out full name for crush #3!");
        }
        
        // create formatted names for all crushes
        $formatted1 = formatName($_POST["crushfirst1"], $_POST["crushlast1"]);
        $formatted2 = formatName($_POST["crushfirst2"], $_POST["crushlast2"]);
        $formatted3 = formatName($_POST["crushfirst3"], $_POST["crushlast3"]);
        
        // ensures that at least one crush is entered
        if (($formatted1 == "") && ($formatted2 == "") && ($formatted3 == ""))
        {
            apologize("Come on, you must like someone!");
        }
        
        $result = query("UPDATE crushes SET crush1 = ?, crush2 = ?, crush3 = ? WHERE id = ?", 
        $formatted1, $formatted2, $formatted3, $_SESSION["id"]);
        if ($result === FALSE)
        {
            apologize("Error occurred");
        }
        
        // set matches to 0
        $matchreset = query("UPDATE crushes SET matchstatus1 = ?, matchstatus2 = ?, 
                            matchstatus3 = ? WHERE id = ?", FALSE, FALSE, FALSE, $_SESSION["id"]);
        if ($matchreset === FALSE)
        {
            apologize("Error occurred");
        }
        
            
        // check for matches
        $crushes = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $_SESSION["id"]);
        $matchIDs = checkMatch($crushes[0]);
        $userFreeTimes = createTimeArray($_SESSION["id"]);
        foreach ($matchIDs as $matchID)
        {
            $crushFreeTimes = createTimeArray($matchID);
            $sharedFreeTimes = findSharedFreeTimes($userFreeTimes, $crushFreeTimes);
            $email1 = idToEmail($_SESSION["id"]);
            $email2 = idToEmail($matchID);
            if (!empty($sharedFreeTimes))
            {
                $chosenDate = setUpDate($sharedFreeTimes);
                emailMatches($email1, $email2, $chosenDate[0], $chosenDate[1], $chosenDate[2]);
            }
            else
            {
                emailNoSharedTimes($email1, $email2);
            }   
        }
        
        redirect("crush_portfolio.php");
    }
    
    

?>
