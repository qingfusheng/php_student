<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Courses</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
      function delete_course_entry(tr_node){
        if(!confirm("确认删除!!!")){
          return ;
        }
        console.log(tr_node);
        var delete_course_id = tr_node.getElementsByTagName("td")[0].textContent;
        my_form.delete_from_course_id.value = delete_course_id;
        my_form.submit();
      }
      function modify_course_entry(tr_node){
        var tr_content = document.getElementsByClassName("tr_content");
        for(var i=0;i<tr_content.length;i++){
          tr_content[i].style.display = "none";
        }
        document.getElementsByClassName("tr_content_add")[0].style.display="none";
        var modify_course_tr = document.getElementsByClassName("tr_content_modify")[0];
        modify_course_tr.style.display = "table-row";
        var modify_course_td = modify_course_tr.getElementsByTagName("td");
        my_form.modify_course_id.value = tr_node.getElementsByTagName("td")[0].textContent;
        modify_course_td[1].getElementsByTagName("input")[0].value = tr_node.getElementsByTagName("td")[1].textContent;
        modify_course_td[2].getElementsByTagName("input")[0].value = tr_node.getElementsByTagName("td")[2].textContent;
      }
      function cancel_course_entry_input(){
        document.location.href="/student/course.php";
      }
      function confirm_course_entry_input(){
        my_form.submit();
      }
      function new_course_entry(){
        if(my_form.add_course_no && my_form.add_course_name){
          my_form.submit();
        }else{
          alert("请填写完成后再点击添加按钮进行提交");
          return ;
        }
      }
    </script>
  </head>
  <body>
    <!--The Content Table-->
    <div class="table">
      <form name="my_form" action="./course.php" method="post">
        <input type="hidden" name="delete_from_course_id" value="">
      <table border="1" style="text-align:center;">
        <tr class="tr_header">
          <th style="display:none">课程ID</th>
          <th>课程号</th>
          <th>课程名</th>
          <th>操作</th>
        </tr>
        <!--This is the Content of the table-->
<?php
    include "./database/database.php";
    $Select_Course_SQL = "select * from course";
    $Select_Course_Result = mysqli_query($serverLink, $Select_Course_SQL);
    while($course = mysqli_fetch_array($Select_Course_Result)){
      echo "<tr class='tr_content'>";
    	echo "<td style='display:none'>".$course['course_id']."</td>";
    	echo "<td>".$course['course_no']."</td>";
    	echo "<td>".$course['course_name']."</td>";
      echo "<td><input type='button' class='delete_button' value='删除' onclick='delete_course_entry(this.parentElement.parentElement)'>";
      echo "<input type='button' class='modify_button' value='修改' onclick='modify_course_entry(this.parentElement.parentElement)'></td>";
      echo "</tr>";
    }
?>
        <!--This is the Add_Part tr of the table-->
        <tr class="tr_content_add">
          <td style="display:none"><input type="hidden" name="add_course_id"></td>
          <td><input type="text" name="add_course_no" value=""></td>
          <td><input type="text" name="add_course_name" value=""></td>
          <td><input type="button" class="add_course_button" value="添加" onclick="new_course_entry()" style="width:100%;"></td>
        </tr>
        <!--This is the Modify_Part tr of the table-->
        <tr class="tr_content_modify" style="display:none;">
          <td style="display:none"><input type="hidden" name="modify_course_id"></td>
          <td><input type="text" name="modify_course_no" value=""></td>
          <td><input type="text" name="modify_course_name" value=""></td>
          <td>
            <input type="button" class="cancel_course_button" value="取消" onclick="cancel_course_entry_input()">
            <input type="button" class="confirm_course_button" value="确认" onclick="confirm_course_entry_input()">;
          </td>
        </tr>
      </table>
    </div>

<?php
  if($_POST){
    // delete selected entry
    if($_POST["delete_from_course_id"]){
      $delete_from_course_id = $_POST["delete_from_course_id"];
      $delete_course_sql = "delete from course where course_id=".$delete_from_course_id;
      $delete_course_sql_result = mysqli_query($serverLink, $delete_course_sql);
      if($delete_course_sql_result){
        echo "<script>alert('删除成功!')</script>";
        echo "<script>document.location.href='/student/course.php'</script>";
      }else{
        if(mysqli_errno($serverLink)==1451){
          echo "<script>alert('嘀!执行删除指令失败，小主请留意是否其他表仍然保留本条数据');</script>";
          echo "<script>document.location.href='/student/course.php'</script>";
        }else{
        echo "<script>alert('执行删除命令失败!');document.location.href='/student/course.php'</script>";
        }
      }
    }
    // add new course entry
    if($_POST["add_course_no"]){
      $new_course_no = $_POST["add_course_no"];
      $new_course_name = $_POST["add_course_name"];
      $new_course_sql = "INSERT INTO course VALUES(NULL, '".$new_course_no."', '".$new_course_name."')";
      echo "<script>alert('".$new_course_sql."')</script>";
      $new_course_sql_result = mysqli_query($serverLink, $new_course_sql) or die("<script>alert('添加失败，请检查输入并重新添加');document.location.href='/student/course.php'</script>");
      echo "<script>alert('添加成功!');document.location.href='/student/course.php';</script>";
    }
    // modify selected entry
    if($_POST["modify_course_no"]){
      $modify_course_no = $_POST["modify_course_no"];
      $modify_course_name = $_POST["modify_course_name"];
      $modify_course_id = $_POST["modify_course_id"];
      $modify_course_sql = "UPDATE course SET course_no='".$modify_course_no."', course_name='".$modify_course_name."' WHERE course_id=".$modify_course_id;
      $modify_course_sql_result = mysqli_query($serverLink, $modify_course_sql) or die("<script>alert('执行更新命令失败，请检查输入并重新提交');document.location.href='/student/course.php'</script>");
      echo "<script>alert('更新成功!');document.location.href='/student/course.php'</script>;";
    }
  }
?>

<?php
mysqli_free_result($Select_Course_Result);
?>
  </body>
</html>