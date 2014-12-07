<div>
    <h2>Has your availibility changed?</h2>
    <p>Remember, there has to be mutual open time slots with you and a crush to have a date! <br>
        Be liberal with your times!</p>
</div>
<form action="update_time.php" method="post">
    <fieldset>
        
        <div class="times">
            <p>
                Sunday:
                <select name="sunStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="sunEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        <div class="times">
            <p>
                Monday:
                <select name="monStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="monEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        <div class="times">
            <p>
                Tuesday:
                <select name="tuesStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="tuesEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        <div class="times">
            <p>
                Wednesday:
                <select name="wedStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="wedEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        <div class="times">
            <p>
                Thursday:
                <select name="thursStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="thursEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        
        <div class="times">
            <p>
                Friday:
                <select name="friStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="friEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        <div class="times">
            <p>
                Saturday:
                <select name="satStart">
                <?php require("startselector.php"); ?>
                </select>
                <select name="satEnd">
                <?php require("endselector.php"); ?>
                </select>
            </p>
        </div>
        
        
        

        <div class="form-group">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </fieldset>
</form>
<div>
    or <a href="logout.php">log out</a>
</div>


