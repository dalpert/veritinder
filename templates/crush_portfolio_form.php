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
            <font size="6"><strong><?= "Current Crushes" ?></strong></font>
        </br>
    </td>
</tr> 

<table border="1" align="center" cellpadding="5" cellspacing="0" width="250">
    
    <?php foreach ($crushes as $crush): ?>

    
        <tr><td><font size="5"><?= unformatName($crush["crush1"]) ?></font></td></tr>
        <tr><td><font size="5"><?= unformatName($crush["crush2"]) ?></font></td></tr>
        <tr><td><font size="5"><?= unformatName($crush["crush3"]) ?></font></td></tr>
    

    <?php endforeach ?>

</table>


<tr>
    <td>
        <br>
            <font size="6"><strong><?= "Current Availability" ?></strong></font>
        </br>
    </td>
</tr> 
<table border="1" align="center" cellpadding="5" cellspacing="0" width="250">
       
        <?php if($times[0] != 0): ?>
            <tr><td><font size="4"><?= "Sunday: " . $times[0] . " - " . $times[1]?></font></td></tr>
        <?php endif ?>
        
        <?php if($times[2] != 0): ?>
            <tr><td><font size="4"><?= "Monday: " . $times[2] . " - " . $times[3]?></font></td></tr>
        <?php endif ?>
        
        <?php if($times[4] != 0): ?>        
            <tr><td><font size="4"><?= "Tuesday: " . $times[4] . " - " . $times[5]?></font></td></tr>
        <?php endif ?>        
        
        <?php if($times[6] != 0): ?>
            <tr><td><font size="4"><?= "Wednesday: " . $times[6] . " - " . $times[7]?></font></td></tr>
        <?php endif ?>
       
        <?php if($times[8] != 0): ?>       
            <tr><td><font size="4"><?= "Thursday: " . $times[8] . " - " . $times[9]?></font></td></tr>
        <?php endif ?>
        
        <?php if($times[10] != 0): ?>
            <tr><td><font size="4"><?= "Friday: " . $times[10] . " - " . $times[11]?></font></td></tr>    
        <?php endif ?>

        <?php if($times[12] != 0): ?>
            <tr><td><font size="4"><?= "Saturday: " . $times[12] . " - " . $times[13]?></font></td></tr>
        <?php endif ?>        

</table>

<div>
    <br>
        <a href="logout.php">log out</a>
    </br>
</div>
