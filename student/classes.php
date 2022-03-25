<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Classes</title>
  </head>
  <body>
    <div class="table">
      <table border="1">
        <tr>
          <th>班级ID</th>
          <th>班级号</th>
          <th>班级名</th>
          <th>操作</th>
        </tr>
<?php
    include "./database/database.php";
    $Select_Class_SQL = "select * from classes";
    $Select_Class_Result = mysqli_query($serverLink, $Select_Class_SQL);
    while($class = mysqli_fetch_array($Select_Class_Result)){
      echo "<tr>";
    	echo "<td>".$class['class_id']."</td>";
    	echo "<td>".$class['class_no']."</td>";
    	echo "<td>".$class['class_name']."</td>";
      echo "<td><input type='button' class='delete_button' value='删除' onclick=''>";
      echo "<input type='button' class='modify_button' value='修改' onclick=''></td>";
      echo "</tr>";
    }
    

?>
      </table>
    </div>

<?php
mysqli_free_result($Select_Class_Result);
?>
  </body>
</html>