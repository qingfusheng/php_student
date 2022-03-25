<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Student</title>
  </head>
  <body>
    <div class="table">
      <table border="1">
        <tr>
          <th>学生ID</th>
          <th>学生学号</th>
          <th>学生姓名</th>
          <th>学生班级</th>
        </tr>
<?php
    include "./database/database.php";
    $Select_Student_SQL = "select * from student";
    $Select_Student_Result = mysqli_query($serverLink, $Select_Student_SQL);
    while($student = mysqli_fetch_array($Select_Student_Result)){
    	echo "<tr><td>".$student['student_id']."</td>";
    	echo "<td>".$student['student_no']."</td>";
    	echo "<td>".$student['student_name']."</td>";
    	echo "<td>".$student['class_id']."</td></tr>";
    }
?>
      </table>
    </div>

<?php
mysqli_free_result($Select_Student_Result);
?>
  </body>
</html>