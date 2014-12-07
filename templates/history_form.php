<table border="1" align="center" cellpadding="3" cellspacing="0" width="600">
    
    <tr>
        <td><strong>Transaction</strong></td>
        <td><strong>Timestamp</strong></td>
        <td><strong>Stock</strong></td>
        <td><strong>Shares</strong></td>
        <td><strong>Price per share</strong></td>
        <td><strong>Money moved</strong></td>
    </tr>
    
    <?php foreach ($positions as $position): ?>

    <tr>
        <td><?= $position["transaction"] ?></td>
        <td><?= $position["datetime"] ?></td>
        <td><?= strtoupper($position["symbol"]) ?></td>
        <td><?= $position["shares"] ?></td>
        <td><?= number_format($position["price"], 2) ?></td>
        <td><?= number_format($position["cost"], 2) ?></td>
    </tr>

    <?php endforeach ?>

</table>

<div>
    <br>
        or <a href="logout.php">log out</a>
    </br>
</div>

