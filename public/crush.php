<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("crush_form.php", ["title" => "Crushes!"]);
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
               
        // check if user already has crushes
        $check = query("SELECT * FROM crushes WHERE id = ?", $_SESSION["id"]);
        if ($check == NULL)
        {                
            // insert crushes into database
            $result = query("INSERT INTO crushes (id, crush1, crush2, crush3) VALUES(?, ?, ?, ?)", 
            $_SESSION["id"], $formatted1, $formatted2, $formatted3);
            if ($result === FALSE)
            {
                apologize("Error occurred");
            }
            
            // check for matches
            $crushes = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $_SESSION["id"]);
            checkMatch($crushes[0]);
            redirect("time.php");
        }
        else
        {
            apologize("You already entered crushes");
        }
    }
    
    

?>
