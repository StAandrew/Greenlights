<html>
<body bgcolor=lightgreen>
<form name=course_entry method=post action="Rating.php">
    <br>
<h1>Add Your New Course</h1>
<input type=text placeholder="Enter Course Name" name=course_name size=100>
<p>
<table>
<tr>
<td><h3>Rating options</h3></td>
<td><h3>Group or Indivividual</h3></td>
</tr>
<tr>
<td><input type=radio name=fillin value=fillin> Fill in Rating Criteria</td>
<td><input type=radio name=type value=group> Group</td>
</tr>
<tr>
<td><input type=radio name=fillin value=students> Let students choose rating criteria</td>
<td><input type=radio name=type value=individual>Individual</td>
</tr>
</table>
<p>
Number of weeks:
<br>
<input type=text placeholder="Enter a number..." name=weeks size=20><p>
<input type=submit name=add value="Add New Course">
</form>
</body>
</html>




