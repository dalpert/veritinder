<tr>
    <td>
        <br>
            <font size="5"><strong><?= "Crushes" ?></strong></font>
        </br>
    </td>
</tr> 

<table border="1" align="center" cellpadding="3" cellspacing="0" width="300">
    
    <tr>
        <td><strong>Crushes</strong></td>
    </tr>
    
    <?php foreach ($crushes as $crush): ?>

    <tr>
        <td><?= unformatName($crush["crush1"]) ?></td>
        <td><?= unformatName($crush["crush2"]) ?></td>
        <td><?= unformatName($crush["crush3"]) ?></td>
    </tr>

    <?php endforeach ?>

</table>

<div>
    <br>
        or <a href="logout.php">log out</a>
    </br>
</div>
