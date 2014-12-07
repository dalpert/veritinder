<?php

    // configuration
    require("../includes/config.php"); 
    
    // stores five attributes of a transaction in an associative array
    $positions = [];
    $rows = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
    foreach ($rows as $row)
    {
            $positions[] = [
            "transaction" => $row["transaction"],
            "datetime" => $row["datetime"],
            "symbol" => $row["symbol"],
            "shares" => $row["shares"],
            "price" => $row["price"],
            "cost" => ($row["price"] * $row["shares"])
            ];
    }
    
    // render portfolio
    render("history_form.php", ["positions" => $positions, "title" => "history"]);

?>

