<?php

    // configuration
    require("../includes/config.php"); 
    
    $crushes = [];
    $rows = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $_SESSION["id"]);

    $timesArray = query("SELECT sunStart, sunEnd, monStart, monEnd, tuesStart, tuesEnd, wedStart, 
                        wedEnd, thursStart, thursEnd, friStart, friEnd, satStart, satEnd FROM times 
                        WHERE id = ?", $_SESSION["id"]);
    $timesArray2 = [];
    $timesArray = $timesArray[0];
    $counter = 0;
    foreach ($timesArray as $time)
    {
        $timesArray2[$counter] = $time;
        $counter++;
    }
    for ($i = 0; $i < $counter; $i++)
    {
        if ($timesArray2[$i] != 0)
        {
            $timesArray2[$i] = intToFormattedTime($timesArray2[$i]);
        }
    }
    for ($i = 0; $i < $counter; $i += 2)   
    { 
        if (($timesArray2[$i] == 0) && ($timesArray2[$i+1] == 0))
        {
            $timesArray2[$i] = "Unavailable";
            $timesArray2[$i+1] = "";
            
        }
    }
    render("crush_portfolio_form.php", ["crushes" => $rows, "times" => $timesArray2]);

?>

