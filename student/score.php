<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Score</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
        function delete_score(score){
          var msg="确认删除？";
          if(!confirm(msg)==true){
            return;
          }
          _form.user_id.value = score;
          _form.operate.value = "delete";
          _form.submit()
        }
        function modify_score(tr_node){
          var tr_score_lists = document.getElementsByClassName("tr_score");
          for(var i=0;i<tr_score_lists.length;i++)
            tr_score_lists[i].style.display = "none";
          document.getElementsByClassName("tr_score_add")[0].style.display="none";
          document.getElementsByClassName("tr_score_modify")[0].style.display = "table-row";
          var ths_modify = document.getElementsByClassName("tr_score_modify")[0].getElementsByTagName("td");
          var ths_old = tr_node.getElementsByTagName("td");
          console.log(ths_modify)
          ths_modify[0].getElementsByTagName("input")[0].value = ths_old[0].textContent;
          ths_modify[1].textContent = ths_old[1].textContent;
          ths_modify[2].textContent = ths_old[2].textContent;
          ths_modify[3].getElementsByTagName("input")[0].value = ths_old[3].textContent;
          
        }
        function add_score(){
          _form.add_score_student.value = document.getElementById("add_new_student_select").value;
          _form.add_score_course.value = document.getElementById("add_new_course_select").value;
          _form.submit();
        }
        function tr_modified_cancel(){
          document.location.href='/student/score.php';
        }
        function tr_modified_confirm(){
          _form.submit();
        }
    </script>
  </head>
  <body>
    <div class="table">
      <form name="_form" aciton="./score.php" method="post">
        <input type="hidden" name="user_id"/>
        <input type="hidden" name="operate"/>
        <table border="1" style="text-align:center;">
          <tr class="header">
            <th style="display:none">成绩ID</th>
            <th>学生学号</th>
            <th>课程の号</th>
            <th>获得分数</th>
            <th>操作</th>
          </tr>
<?php
    include "./database/database.php";
    $Select_Score_SQL = "select * from score";
    $Select_Score_Result = mysqli_query($serverLink, $Select_Score_SQL);
    while($score = mysqli_fetch_array($Select_Score_Result)){
      echo "<tr class='tr_score'>";
    	echo "<td style='display:none'>".$score['score_id']."</td>";
      $select_student_name_sql = "SELECT student_name FROM student WHERE student_id=".$score["student_id"];
      $select_student_name_result = mysqli_query($serverLink,$select_student_name_sql);
      $select_student_name = mysqli_fetch_array($select_student_name_result)["student_name"];
    	echo "<td>".$select_student_name."</td>";
      $select_course_name_sql = "SELECT course_name FROM course WHERE course_id=".$score["course_id"];
      $select_course_name_result = mysqli_query($serverLink, $select_course_name_sql);
      $select_course_name = mysqli_fetch_array($select_course_name_result)["course_name"];
    	echo "<td>".$select_course_name."</td>";
    	echo "<td>".$score["grade"]."</td>";
    	echo "<td><input type='button' value='删除' onclick=\"delete_score('".$score["score_id"]."')\">";
    	echo "<input type='button' class='modified_input' value='修改' onclick=\"modify_score(this.parentElement.parentElement)\"></td>";
    	echo "</tr>";
    }
?>
          <tr class="tr_score_modify" style="display:none;">
            <td style='display:none'>
              <input type="hidden" value="" name="mo_score_id">
            </td>
            <td></td>
            <td></td>
            <td>
              <input name="mo_grade" type="text" value="">
            </td>
            <td>
              <input type="button" id="modified_cancel" value="取消" onclick="tr_modified_cancel()">
              <input type="button" id="modified_confirm" value="确认" onclick="tr_modified_confirm()">
            </td>
          </tr>
          <tr class="tr_score_add">
            <td style='display:none'></td>
            <td>
              <input type="hidden" name="add_score_student">
              <Select id="add_new_student_select">
                <option value="">-请选择添加成绩的学生</option>
<?php
$student_sql = "Select student_id, student_name from student";
$student_sql_result = mysqli_query($serverLink, $student_sql);
while($student=mysqli_fetch_array($student_sql_result)){
  echo "<option value='".$student["student_id"]."'>".$student["student_name"]."</option>";
}
?>
              </Select></td>
            <td>
              <input type="hidden" name="add_score_course">
              <Select id="add_new_course_select">
                <option value="">-请选择添加成绩的课程</option>
<?php
$course_sql = "Select course_id, course_name from course";
$course_sql_result = mysqli_query($serverLink, $course_sql);
while($course=mysqli_fetch_array($course_sql_result)){
  echo "<option value='".$course["course_id"]."'>".$course["course_name"]."</option>";
}
?>
              </Select>
            </td>
            <td>
              <input name="add_score_grade" type="text" value="">
            </td>
            <td><input type="button" value="添加" onclick="add_score()" style="width:100%;"></td>
          </tr>
        </table>
      </form>
    </div>

<?php
  if($_POST){
    if($_POST["user_id"]){
      $user_id = $_POST["user_id"];
      $operate = $_POST["operate"];
      if($operate == "delete"){
        $deleteSql = "DELETE FROM score WHERE score_id=".(string)$user_id;
        $SqlResult = mysqli_query($serverLink, $deleteSql);
        if($SqlResult){
          echo "<script>alert('删除成功！')</script>";
          echo "<script>document.location.href='/student/score.php'</script>";
        }
        else{
          echo "<script>alert('执行删除命令错误，删除失败')</script>";
          echo "<script>document.location.href='/student/score.php'</script>";
        }
      }
    }
    if($_POST["add_score_student"]){
      $add_score_student_id = $_POST["add_score_student"];
      $add_score_course_id = $_POST["add_score_course"];
      $add_score_grade = $_POST["add_score_grade"];
      $insert_sql = "INSERT INTO score VALUES(null, \"".$add_score_student_id."\",\"".$add_score_course_id."\",".$add_score_grade.")";
      $insert_sql_result = mysqli_query($serverLink, $insert_sql);
      if($insert_sql_result){
        echo "<script>alert('添加成功');</script>";
        echo "<script>document.location.href='/student/score.php'</script>";
      }else{
        echo "<script>alert('执行添加命令失败，请检查');</script>";
        echo "<script>document.location.href='/student/score.php'</script>";
      }
    }
    if($_POST["mo_score_id"]){
      $mo_score_id = $_POST["mo_score_id"];
      $mo_grade = $_POST["mo_grade"];
      $update_sql = "UPDATE score set grade=".$mo_grade." WHERE score_id=".$mo_score_id;
      $update_sql_result = mysqli_query($serverLink, $update_sql) or die("<script>alert('执行修改命令失败，请检查');document.location.href='/student/score.php'</script>");
      echo "<script>alert('修改成功！')</script>";
      echo "<script>document.location.href='/student/score.php'</script>";
    }
  }
?>

<?php
mysqli_free_result($Select_Score_Result);
?>
  </body>
</html>