<?php

    // configuration
    require("../includes/config.php"); 
    
    // amount of cash user has
    // $cash = query("SELECT crush1 FROM users WHERE id = ?", $_SESSION["id"]);
    
    // looks up a stock by its symbol, adding its attributes to an associative array
    $crushes = [];
    $rows = query("SELECT crush1, crush2, crush3 FROM crushes WHERE id = ?", $_SESSION["id"]);
    //$timeArray1 = createTimeArray(21);
    //$timeArray2 = createTimeArray(23);
    //dump($timeArray2);
    //$sharedFreeTimes = findSharedFreeTimes(createTimeArray(21), createTimeArray(23));
    //dump($sharedFreeTimes);
    //emailMatches("alpert@college.harvard.edu", "dylanfarrell@college.harvard.edu");
    //$user = checkExistence("dyln.farrell");
    //dump($user);
    // render portfolio
    render("crush_portfolio_form.php", ["crushes" => $rows]);

?>

