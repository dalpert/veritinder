<?php

    // configuration
    require("../includes/config.php"); 
    
    // the users crushes
    $rows = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $_SESSION["id"]);

    // times that the user is available
    $timesArray = query("SELECT sunStart, sunEnd, monStart, monEnd, tuesStart, tuesEnd, wedStart, 
                        wedEnd, thursStart, thursEnd, friStart, friEnd, satStart, satEnd FROM times 
                        WHERE id = ?", $_SESSION["id"]);
    $timesArray = $timesArray[0];
    
    // copy elements from timesArray into a new array times with ints as indices
    // this makes it easire to manipulate the elements
    $times = [];
    $counter = 0;
   
    foreach ($timesArray as $time)
    {
        $times[$counter] = $time;
        $counter++;
    }
    
    // format nonzero times to a formatted time (8:00PM for example)
    for ($i = 0; $i < $counter; $i++)
    {
        if ($times[$i] != 0)
        {
            $times[$i] = intToFormattedTime($times[$i]);
        }
    }

    render("crush_portfolio_form.php", ["crushes" => $rows, "times" => $times]);
?>

