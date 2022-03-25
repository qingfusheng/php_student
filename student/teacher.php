<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Teacher</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
        function delete_teacher(teacher){
          var msg="确认删除？";
          if(!confirm(msg)==true){
            return;
          }
          _form.user_id.value = teacher;
          _form.operate.value = "delete";
          _form.submit()
        }
        function modify_teacher(tr_node){
          var tr_teacher_lists = document.getElementsByClassName("tr_teacher");
          for(var i=0;i<tr_teacher_lists.length;i++)
            tr_teacher_lists[i].style.display = "none";
          document.getElementsByClassName("tr_teacher_add")[0].style.display="none";
          document.getElementsByClassName("tr_teacher_modify")[0].style.display = "table-row";
          var ths_modify = document.getElementsByClassName("tr_teacher_modify")[0].getElementsByTagName("td");
          var ths_old = tr_node.getElementsByTagName("td");
          console.log(ths_modify)
          ths_modify[0].getElementsByTagName("input")[0].value = ths_old[0].textContent;
          ths_modify[1].getElementsByTagName("input")[0].value = ths_old[1].textContent;
          ths_modify[2].getElementsByTagName("input")[0].value = ths_old[2].textContent;
          
        }
        function add_teacher(){
            console.log(document.getElementById("add_new_entry").value);
          _form.the_class_id.value = document.getElementById("add_new_entry").value;
          _form.submit();
        }
        function tr_modified_cancel(){
          document.location.href='/student/teacher.php';
        }
        function tr_modified_confirm(){
          _form.mo_class_id.value = document.getElementById("mo_add_new_entry").value;
          _form.submit();
        }
    </script>
  </head>
  <body>
    <div class="table">
      <form name="_form" aciton="./teacher.php" method="post">
        <input type="hidden" name="user_id"/>
        <input type="hidden" name="operate"/>
        <table border="1" style="text-align:center;">
          <tr class="header">
            <th style="display:none">教师ID</th>
            <th>教师工号</th>
            <th>教师名称</th>
            <th>管理班级</th>
            <th>操作</th>
          </tr>
<?php
    include "./database/database.php";
    $Select_Teacher_SQL = "select * from teacher";
    $Select_Teacher_Result = mysqli_query($serverLink, $Select_Teacher_SQL);
    while($teacher = mysqli_fetch_array($Select_Teacher_Result)){
        echo "<tr class='tr_teacher'>";
    	echo "<td style='display:none'>".$teacher['teacher_id']."</td>";
    	echo "<td>".$teacher['teacher_no']."</td>";
    	echo "<td>".$teacher['teacher_name']."</td>";
      $teacher_class_sql = "select class_name from classes where class_id=".$teacher["class_id"];
      $class_name_result = mysqli_query($serverLink, $teacher_class_sql);
      $class_name = mysqli_fetch_array($class_name_result)["class_name"];
    	echo "<td>".$class_name."</td>";
    	echo "<td><input type='button' value='删除' onclick=\"delete_teacher('".$teacher["teacher_id"]."')\">";
    	echo "<input type='button' class='modified_input' value='修改' onclick=\"modify_teacher(this.parentElement.parentElement)\"></td>";
    	echo "</tr>";
    }
?>
          <tr class="tr_teacher_modify" style="display:none">
            <td style='display:none'><input type="hidden" value="" name="mo_teacher_id"></td>
            <td><input type="text" value="" name="mo_teacher_no"></td>
            <td><input type="text" value="" name="mo_teacher_name"></td>
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
            <td>
              <input type="button" id="modified_cancel" value="取消" onclick="tr_modified_cancel()">
              <input type="button" id="modified_confirm" value="确认" onclick="tr_modified_confirm()">
            </td>
          </tr>
          <tr class="tr_teacher_add">
            <td style='display:none'></td>
            <td><input type="text" name="the_teacher_no"></td>
            <td><input type="text" name="the_teacher_name"></td>
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
            <td><input type="button" value="添加" onclick="add_teacher()"></td>
          </tr>
        </table>
      </form>
    </div>

<?php
  if($_POST){
    if($_POST["user_id"]){
      $user_id = $_POST["user_id"];
      $operate = $_POST["operate"];
      echo $operate;
      echo $user_id;
      if($operate == "delete"){
        $deleteSql = "DELETE FROM teacher WHERE teacher_id=".(string)$user_id;
        $SqlResult = mysqli_query($serverLink, $deleteSql);
        if($SqlResult){
          echo "<script>alert('删除成功！')</script>";
          echo "<script>document.location.href='/student/teacher.php'</script>";
        }
        else{
          echo "<script>alert('执行删除命令错误，删除失败')</script>";
          echo "<script>document.location.href='/student/teacher.php'</script>";
        }
      }
    }
    if($_POST["the_teacher_no"]){
      $the_teacher_no = $_POST["the_teacher_no"];
      $the_teacher_name = $_POST["the_teacher_name"];
      $the_class_id = $_POST["the_class_id"];
      $insert_sql = "INSERT INTO teacher VALUES(null, \"".$the_teacher_no."\",\"".$the_teacher_name."\",".$the_class_id.")";
      $insert_sql_result = mysqli_query($serverLink, $insert_sql);
      if($insert_sql_result){
        echo "<script>alert('添加成功');</script>";
        echo "<script>document.location.href='/student/teacher.php'</script>";
      }else{
        echo "<script>alert('执行添加命令失败，请检查');</script>";
        echo "<script>document.location.href='/student/teacher.php'</script>";
      }
    }
    if($_POST["mo_teacher_no"]){
      $mo_teacher_id = $_POST["mo_teacher_id"];
      $mo_teacher_no = $_POST["mo_teacher_no"];
      $mo_teacher_name = $_POST["mo_teacher_name"];
      $mo_class_id = $_POST["mo_class_id"];
      echo $mo_class_id;
      $update_sql = "UPDATE teacher set teacher_no=".$mo_teacher_no.", teacher_name='".$mo_teacher_name."',class_id=".$mo_class_id." WHERE teacher_id=".$mo_teacher_id;
      echo $update_sql;
      $update_sql_result = mysqli_query($serverLink, $update_sql) or die("<script>alert('执行修改命令失败，请检查');document.location.href='/student/teacher.php'</script>");
      echo "<script>alert('修改成功！')</script>";
      echo "<script>document.location.href='/student/teacher.php'</script>";
    }
  }
?>

<?php
mysqli_free_result($Select_Teacher_Result);
?>
  </body>
</html>