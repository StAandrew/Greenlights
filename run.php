<?php
if (!isset($_POST['submit']))
    echo "Not set";
else
{
foreach($table->find('#table') as $table)
{ 
     // returns all the <tr> tag inside $table
     $all_trs = $table->find('tr');
     $count = count($all_trs);
     echo $count;
}
}
?>