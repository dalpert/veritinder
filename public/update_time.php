<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("update_time_form.php", ["title" => "When are you free?"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // checks that both fields are filled out
        if ((!empty($_POST["sunStart"]) && empty($_POST["sunEnd"]))
           || (empty($_POST["sunStart"]) && !empty($_POST["sunEnd"])))
        {
            apologize("Please fill out both a start and end time on Sunday!");
        }
        if ((!empty($_POST["monStart"]) && empty($_POST["monEnd"]))
           || (empty($_POST["monStart"]) && !empty($_POST["monEnd"])))
        {
            apologize("Please fill out both a start and end time on Monday!");
        }
        if ((!empty($_POST["tuesStart"]) && empty($_POST["tuesEnd"]))
           || (empty($_POST["tuesStart"]) && !empty($_POST["tuesEnd"])))
        {
            apologize("Please fill out both a start and end time on Tuesday!");
        }
        if ((!empty($_POST["wedStart"]) && empty($_POST["wedEnd"]))
           || (empty($_POST["wedStart"]) && !empty($_POST["wedEnd"])))
        {
           apologize("Please fill out both a start and end time on Wednesday!");
        }
        if ((!empty($_POST["thursStart"]) && empty($_POST["thursEnd"]))
           || (empty($_POST["thursStart"]) && !empty($_POST["thursEnd"])))
        {
            apologize("Please fill out both a start and end time on Thursday!");
        }
        if ((!empty($_POST["friStart"]) && empty($_POST["friEnd"]))
           || (empty($_POST["friStart"]) && !empty($_POST["friEnd"])))
        {
           apologize("Please fill out both a start and end time on Friday!");
        }
        if ((!empty($_POST["satStart"]) && empty($_POST["satEnd"]))
           || (empty($_POST["satStart"]) && !empty($_POST["satEnd"])))
        {
            apologize("Please fill out both a start and end time on Saturday!");
        }
             
        // checks that start times are earlier than end times       
        if ($_POST["sunStart"] >= $_POST["sunEnd"] && $_POST["sunStart"] != 0)
        {
           apologize("Your Sunday is over before it began!");
        }
        if ($_POST["monStart"] >= $_POST["monEnd"] && $_POST["monStart"] != 0)
        {
           apologize("Your Monday is over before it began!");
        }
        if ($_POST["tuesStart"] >= $_POST["tuesEnd"] && $_POST["tuesStart"] != 0)
        {
           apologize("Your Tuesday is over before it began!");
        }
        if ($_POST["wedStart"] >= $_POST["wedEnd"] && $_POST["wedStart"] != 0)
        {
           apologize("Your Wednesday is over before it began!");
        }
        if ($_POST["thursStart"] >= $_POST["thursEnd"] && $_POST["thursStart"] != 0)
        {
           apologize("Your Thursday is over before it began!");
        }
        if ($_POST["friStart"] >= $_POST["friEnd"] && $_POST["friStart"] != 0)
        {
           apologize("Your Friday is over before it began!");
        }
        if ($_POST["satStart"] >= $_POST["satEnd"] && $_POST["satStart"] != 0)
        {
           apologize("Your Saturday is over before it began!");
        }
             
        /*$dropdownsFilled = 0;
        if ($_POST["satStart"])*/
            
         
         
         
        // update times
        $result = query("UPDATE times SET sunStart = ?, sunEnd = ?, monStart = ?, monEnd = ?, tuesStart = ?, 
                       tuesEnd = ?, wedStart = ?, wedEnd = ?, thursStart = ?, thursEnd = ?, friStart = ?, friEnd = ?, 
                       satStart = ?, satEnd = ? WHERE id = ?", $_POST["sunStart"], $_POST["sunEnd"], $_POST["monStart"], 
                       $_POST["monEnd"], $_POST["tuesStart"], $_POST["tuesEnd"], $_POST["wedStart"], $_POST["wedEnd"],
                       $_POST["thursStart"], $_POST["thursEnd"], $_POST["friStart"], $_POST["friEnd"], 
                       $_POST["satStart"], $_POST["satEnd"], $_SESSION["id"]);
         
        if ($result === FALSE)
        {
            apologize("Error occurred");
        }
        
        
        redirect("crush_portfolio.php");
    }
    
    

?>
