<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // ensures that both username and password are filled out
        if (empty($_POST["firstname"]) === TRUE || empty($_POST["lastname"]) === TRUE ||
        empty($_POST["password"]) === TRUE ||  empty($_POST["email"]) === TRUE)
        {
            apologize("Please fill out all fields");
        }
        
        // or if post pass doesnt equal post pass confirmation inform registrants of their error
        if ($_POST["password"] !== $_POST["passconfirmation"])
        {
            apologize("Your passwords are not the same");
        }
        
        // or if post email doesnt equal post email confirmation inform registrants of their error
        if ($_POST["email"] !== $_POST["emailconfirmation"])
        {
            apologize("Your email addresses are not the same");
        }
        
        // create a "formatted name" (firstname.lastname)
        $formattedname = strtolower($_POST["firstname"]) . "." . strtolower($_POST["lastname"]); 
        
        // insert new user into database
        $result = query("INSERT INTO users (firstname, lastname, formattedname, email, hash) 
                        VALUES(?, ?, ?, ?, ?)", $_POST["firstname"], $_POST["lastname"], $formattedname, 
                        $_POST["email"], crypt($_POST["password"]));
        if ($result === FALSE)
        {
            apologize("Error occurred");
        }
        
        // saves session and redirects to index
        else
        {
            $rows = query("SELECT LAST_INSERT_ID() AS id");
            $_SESSION["id"] = $rows[0]["id"];
            redirect("crush.php");
        }
    }

?>
