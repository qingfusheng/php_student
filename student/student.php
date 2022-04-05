<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Student</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
        function delete_student(student){
          var msg="确认删除？";
          if(!confirm(msg)==true){
            return;
          }
          _form.user_id.value = student;
          _form.operate.value = "delete";
          _form.submit()
        }
        function modify_student(tr_node){
          var tr_student_lists = document.getElementsByClassName("tr_student");
          for(var i=0;i<tr_student_lists.length;i++)
            tr_student_lists[i].style.display = "none";
          document.getElementsByClassName("tr_student_add")[0].style.display="none";
          document.getElementsByClassName("tr_student_modify")[0].style.display = "table-row";
          var ths_modify = document.getElementsByClassName("tr_student_modify")[0].getElementsByTagName("td");
          var ths_old = tr_node.getElementsByTagName("td");
          console.log(ths_modify)
          ths_modify[0].getElementsByTagName("input")[0].value = ths_old[0].textContent;
          ths_modify[1].getElementsByTagName("input")[0].value = ths_old[1].textContent;
          ths_modify[2].getElementsByTagName("input")[0].value = ths_old[2].textContent;
          
        }
        function add_student(){
            console.log(document.getElementById("add_new_entry").value);
          _form.the_class_id.value = document.getElementById("add_new_entry").value;
          _form.submit();
        }
        function tr_modified_cancel(){
          document.location.href='/student/student.php';
        }
        function tr_modified_confirm(){
          _form.mo_class_id.value = document.getElementById("mo_add_new_entry").value;
          _form.submit();
        }
        function get_each_score(num){
            document.location.href = "/student/score.php?stu="+num;
        }
    </script>
    <style type="text/css">
      table{
        margin-top:170px;
        text-align:center;
      }
      th{
        width:400px;
        height:40px;
        text-align:center;
      }
      td{
        height:30px;
        text-align:center;
      }
      .operate_button{
        width:100px;
      }
      .get_each_score_button_h{
          width:100px;
      }
      .entry_th_id{
        display: none;
      }
      .tr_modify{
        display:none;
      }
      .add_button{
        width:100%;
      }
      ._input{
        width:95%;
        height:80%;
        border:none;
      }
      ._button{
        height:95%;
      }
      .get_each_score_button{
          width:90%;
          height:90%;
      }
      .td_left_button{
        width:48%;
        float:left;
      }
      .td_right_button{
        width:48%;
        float:right;
      }
      Select{
        width:95%;
        height:90%;
      }
    </style>
  </head>
  <body>
    <div class="table">
      <form name="_form" aciton="./student.php" method="post">
        <input type="hidden" name="user_id"/>
        <input type="hidden" name="operate"/>
        <table border="10" align="center">
          <tr class="header">
            <th style="display:none">学生ID</th>
            <th>学生学号</th>
            <th>学生姓名</th>
            <th>所属班级</th>
            <th class="operate_button">操作</th>
            <th class="get_each_score_button_h">操作2</th>
          </tr>
<?php
    include_once "./database/database.php";
    $Select_Student_SQL = "select * from student";
    $Select_Student_Result = mysqli_query($serverLink, $Select_Student_SQL);
    while($student = mysqli_fetch_array($Select_Student_Result)){
        echo "<tr class='tr_student'>";
    	echo "<td class='entry_th_id'>".$student['student_id']."</td>";
    	echo "<td>".$student['student_no']."</td>";
    	echo "<td>".$student['student_name']."</td>";
      $student_class_sql = "select class_name from classes where class_id=".$student["class_id"];
      $class_name_result = mysqli_query($serverLink, $student_class_sql);
      $class_name = mysqli_fetch_array($class_name_result)["class_name"];
    	echo "<td>".$class_name."</td>";
    	echo "<td class='operate_button'>";
    	echo "<input type='button' class='td_left_button' value='删除' onclick=\"delete_student('".$student["student_id"]."')\">";
    	echo "<input type='button' class='modified_input td_right_button' value='修改' onclick=\"modify_student(this.parentElement.parentElement)\"></td>";
    	echo "<td><input type='button' class='get_each_score_button' value='查看成绩' onclick=\"get_each_score(".$student["student_id"].")\"></td>";
    	echo "</tr>";
    }
?>
          <tr class="tr_student_modify tr_modify">
            <td class="entry_th_id"><input type="hidden" value="" name="mo_student_id"></td>
            <td><input class="_input" type="text" value="" name="mo_student_no"></td>
            <td><input class="_input" type="text" value="" name="mo_student_name"></td>
            <td>
              <input name="mo_class_id" type="hidden">
              <Select id="mo_add_new_entry">
                <option value="">-请选择班级</option>
                <?php
                $ClassSql = "Select class_id, class_name from classes";
                $ClassSql_Result = mysqli_query($serverLink, $ClassSql);
                while($class=mysqli_fetch_array($ClassSql_Result)){
                  echo "<option value='".$class["class_id"]."'>".$class["class_name"]."</option>";
                }
                ?>
              </Select>  
            </td>
            <td class="operate_button">
              <input class="td_left_button" type="button" id="modified_cancel" value="取消" onclick="tr_modified_cancel()">
              <input class="td_right_button" type="button" id="modified_confirm" value="确认" onclick="tr_modified_confirm()">
            </td>
          </tr>
          <tr class="tr_student_add">
            <td class="entry_th_id"></td>
            <td><input class="_input" type="text" name="the_student_no"></td>
            <td><input class="_input" type="text" name="the_student_name"></td>
            <td>
              <input name="the_class_id" type="hidden">
              <Select id="add_new_entry">
                <option value="">-请选择班级</option>
<?php
$ClassSql = "Select class_id, class_name from classes";
$ClassSql_Result = mysqli_query($serverLink, $ClassSql);
while($class=mysqli_fetch_array($ClassSql_Result)){
  echo "<option value='".$class["class_id"]."'>".$class["class_name"]."</option>";
}
?>
              </Select>  
            </td>
            <td class="operate_button"><input class="add_button" type="button" value="添加" onclick="add_student()" style="width:100%;"></td>
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
        $deleteSql = "DELETE FROM student WHERE student_id=".(string)$user_id;
        $SqlResult = mysqli_query($serverLink, $deleteSql);
        if($SqlResult){
          echo "<script>alert('删除成功！')</script>";
          echo "<script>document.location.href='/student/student.php'</script>";
        }
        else{
          echo "<script>alert('执行删除命令错误，删除失败')</script>";
          echo "<script>document.location.href='/student/student.php'</script>";
        }
      }
    }
    if($_POST["the_student_no"]){
      $the_student_no = $_POST["the_student_no"];
      $the_student_name = $_POST["the_student_name"];
      $the_class_id = $_POST["the_class_id"];
      $insert_sql = "INSERT INTO student VALUES(null, \"".$the_student_no."\",\"".$the_student_name."\",".$the_class_id.")";
      $insert_sql_result = mysqli_query($serverLink, $insert_sql);
      if($insert_sql_result){
        echo "<script>alert('添加成功');</script>";
        echo "<script>document.location.href='/student/student.php'</script>";
      }else{
        echo "<script>alert('执行添加命令失败，请检查');</script>";
        echo "<script>document.location.href='/student/student.php'</script>";
      }
    }
    if($_POST["mo_student_no"]){
      $mo_student_id = $_POST["mo_student_id"];
      $mo_student_no = $_POST["mo_student_no"];
      $mo_student_name = $_POST["mo_student_name"];
      $mo_class_id = $_POST["mo_class_id"];
      $update_sql = "UPDATE student set student_no=".$mo_student_no.", student_name='".$mo_student_name."',class_id=".$mo_class_id." WHERE student_id=".$mo_student_id;
      $update_sql_result = mysqli_query($serverLink, $update_sql) or die("<script>alert('执行修改命令失败，请检查');document.location.href='/student/student.php'</script>");
      echo "<script>alert('修改成功！')</script>";
      echo "<script>document.location.href='/student/student.php'</script>";
    }
  }
?>

<?php
mysqli_free_result($Select_Student_Result);
?>
  </body>
</html>