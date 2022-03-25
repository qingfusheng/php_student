<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Score</title>
  </head>
  <body>
    <div class="table">
      <table border="1">
        <tr>
          <th>成绩编号</th>
          <th>学生编号</th>
          <th>课程编号</th>
          <th>课程分数</th>
        </tr>
<?php
    include "./database/database.php";
    $Select_Score_SQL = "select * from score";
    $Select_Score_Result = mysqli_query($serverLink, $Select_Score_SQL);
    while($score = mysqli_fetch_array($Select_Score_Result)){
    	echo "<tr><td>".$score['score_id']."</td>";
    	echo "<td>".$score['student_id']."</td>";
    	echo "<td>".$score['course_id']."</td>";
    	echo "<td>".$score['grade']."</td></tr>";
    }
?>        
      </table>
    </div>



<?php
mysqli_free_result($Select_Score_Result);
?>
  </body>
</html>