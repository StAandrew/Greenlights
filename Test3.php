<?php
$conn=mysqli_connect("localhost","root","root","Greenlights");

if($_POST[submit])
    {
     foreach ($_POST['item'] as $key => $value) 
        {
            $item = $_POST["item"][$key];
            $price = $_POST["price"][$key];
            $qty = $_POST["qty"][$key];

            $sql = mysql_query("insert into your_table_name values ('','$item', '$price', '$qty')");        
        }

    }   
?>