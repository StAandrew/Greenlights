<html>
<body bgcolor=lightgreen>
<form name=course_entry method=post action="Rating.php">
    <br>
<h1>Add Your Module</h1>
<input type=text placeholder="Enter Module Name" name=module_name size=100>
<p>
<table>

<tr>
<th> Group/Individual</th>
</tr>
<tr>
<td><input type=radio name=type value=group>Group</td>
</tr>
<tr>
<td><input type=radio name=type value=individual>  Individual</td>
</tr>
</table>
<p>
Number of weeks:
<br>
<input type=text placeholder="Enter a number..." name=weeks size=20><p>
<input type=submit name=add value="Add New Module">
</form>
</body>
</html>




