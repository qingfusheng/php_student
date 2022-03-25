<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Course</title>
  </head>
  <body>
    <div class="table">
      <table border="1">
        <tr>
          <th>课程ID</th>
          <th>课程号</th>
          <th>课程名</th>
        </tr>
<?php
    include "./database/database.php";
    $Select_Course_SQL = "select * from course";
    $Select_Course_Result = mysqli_query($serverLink, $Select_Course_SQL);
    while($course = mysqli_fetch_array($Select_Course_Result)){
    	echo "<tr><td>".$course['course_id']."</td>";
    	echo "<td>".$course['course_no']."</td>";
    	echo "<td>".$course['course_name']."</td></tr>";
    }
?>        
      </table>
    </div>



<?php
mysqli_free_result($Select_Course_Result);
?>
  </body>
</html>