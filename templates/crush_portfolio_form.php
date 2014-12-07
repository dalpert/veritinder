<div>
<br>
</div>
<div>
    <a href="update_crush.php">Update Crushes</a>
</div>
<div>
    <a href="update_time.php">Update Times</a>
</div>            


<tr>
    <td>
        <br>
            <font size="5"><strong><?= "Current Crushes" ?></strong></font>
        </br>
    </td>
</tr> 

<table border="1" align="center" cellpadding="5" cellspacing="0" width="250">
    
    <?php foreach ($crushes as $crush): ?>

    
        <tr><td><?= unformatName($crush["crush1"]) ?></td></tr>
        <tr><td><?= unformatName($crush["crush2"]) ?></td></tr>
        <tr><td><?= unformatName($crush["crush3"]) ?></td></tr>
    

    <?php endforeach ?>

</table>


<tr>
    <td>
        <br>
            <font size="5"><strong><?= "Current Availability" ?></strong></font>
        </br>
    </td>
</tr> 
<table border="1" align="center" cellpadding="5" cellspacing="0" width="250">
       
        <tr><td><?= "Sunday: " . $times[0] . " - " . $times[1]?></td></tr>
        <tr><td><?= "Monday: " . $times[2] . " - " . $times[3]?></td></tr>
        <tr><td><?= "Tuesday: " . $times[4] . " - " . $times[5]?></td></tr>
        <tr><td><?= "Wednesday: " . $times[6] . " - " . $times[7]?></td></tr>
        <tr><td><?= "Thursday: " . $times[8] . " - " . $times[9]?></td></tr>
        <tr><td><?= "Friday: " . $times[10] . " - " . $times[11]?></td></tr>    
        <tr><td><?= "Saturday: " . $times[12] . " - " . $times[13]?></td></tr>
        

</table>

<div>
    <br>
        <a href="logout.php">Log Out</a>
    </br>
</div>
