<?php

    // configuration
    require("../includes/config.php"); 
    
    $crushes = [];
    $rows = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $_SESSION["id"]);

    $timesArray = query("SELECT sunStart, sunEnd, monStart, monEnd, tuesStart, tuesEnd, wedStart, 
                        wedEnd, thursStart, thursEnd, friStart, friEnd, satStart, satEnd FROM times 
                        WHERE id = ?", $_SESSION["id"]);
    $timesArray = $timesArray[0];
    $times = [];
    $counter = 0;
    foreach ($timesArray as $time)
    {
        $times[$counter] = $time;
        $counter++;
    }
    for ($i = 0; $i < $counter; $i++)
    {
        if ($times[$i] != 0)
        {
            $times[$i] = intToFormattedTime($times[$i]);
        }
    }
    for ($i = 0; $i < $counter; $i += 2)   
    { 
        if (($times[$i] == 0) && ($times[$i+1] == 0))
        {
            $times[$i] = "Unavailable";
            $times[$i+1] = "";
            
        }
    }
    render("crush_portfolio_form.php", ["crushes" => $rows, "times" => $times]);

?>

