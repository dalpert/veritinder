<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("time_form.php", ["title" => "When are you free?"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
         //checks
         if ($_POST["sunStart"] < $_POST["sunEnd"])
         {
            apologize("Your Sunday is over before it began!");
         }
         if ($_POST["monStart"] < $_POST["monEnd"])
         {
            apologize("Your Monday is over before it began!");
         }
         if ($_POST["tuesStart"] < $_POST["tuesEnd"])
         {
            apologize("Your Tuesday is over before it began!");
         }
         if ($_POST["wedStart"] < $_POST["wedEnd"])
         {
            apologize("Your Wednesday is over before it began!");
         }
         if ($_POST["thursStart"] < $_POST["thursEnd"])
         {
            apologize("Your Thursday is over before it began!");
         }
         if ($_POST["friStart"] < $_POST["friEnd"])
         {
            apologize("Your Friday is over before it began!");
         }
         if ($_POST["satStart"] < $_POST["satEnd"])
         {
            apologize("Your Saturday is over before it began!");
         }
         //endchecks
         
         $result = query("INSERT INTO times (id, sunStart, sunEnd, monStart, monEnd, tuesStart, tuesEnd,
                        wedStart, wedEnd, thursStart, thursEnd, friStart, friEnd, satStart, satEnd) 
                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
                        $_SESSION["id"], $_POST["sunStart"], $_POST["sunEnd"], $_POST["monStart"],
                        $_POST["monEnd"], $_POST["tuesStart"], $_POST["tuesEnd"], $_POST["wedStart"], 
                        $_POST["wedEnd"], $_POST["thursStart"], $_POST["thursEnd"], $_POST["friStart"],
                        $_POST["friEnd"], $_POST["satStart"], $_POST["satEnd"]);
         if ($result === FALSE)
         {
            apologize("Error occurred");
         }
        
        
        redirect("crush_portfolio.php");
    }
    else
    {
        apologize("you already entered crushes");
    }
    
    

?>
