
<table class="table table-striped table-bordered table-list">
    <thead>
        <tr>
            <th>Student name</th>
            <th>Student ID</th>
            <th>Meeting date</th>
            <th>Overall rating</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "TA_development";
        
        $conn = mysqli_connect($servername, $username, $password, $database);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "";

        $sql = "select * from company where activation_code=0";

        $res = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($res)):

    ?>

        <tr>
            <td align="center">
                <button type="submit" class="btn btn-default myButton" value="<?php echo $row['companyid']; ?>" id="accept" name="accept">Accept</button>
            </td>
            <td><?php echo $row['companyid']; ?></td>
            <td><?php echo $row['government_reg_no']; ?></td>
            <td><?php echo $row['company_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
        </tr>

    <?php
        endwhile
    ?>

    </tbody>
</table>
<script>
    $(".myButton").click(function () {
        var company_id = $(this).val();
        $.ajax({
            type:"POST",
            url:"approvecompany.php",
            data:{ comid: company_id },
            success:function () {
                window.location.reload(true);
            }

        });
    });
</script>
