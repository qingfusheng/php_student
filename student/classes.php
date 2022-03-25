<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Classes</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
      function delete_class_entry(tr_node){
        if(!confirm("确认删除!!!")){
          return ;
        }
        console.log(tr_node);
        var delete_class_id = tr_node.getElementsByTagName("td")[0].textContent;
        my_form.delete_from_class_id.value = delete_class_id;
        my_form.submit();
      }
      function modify_class_entry(tr_node){
        var tr_content = document.getElementsByClassName("tr_content");
        for(var i=0;i<tr_content.length;i++){
          tr_content[i].style.display = "none";
        }
        document.getElementsByClassName("tr_content_add")[0].style.display="none";
        var modify_class_tr = document.getElementsByClassName("tr_content_modify")[0];
        modify_class_tr.style.display = "table-row";
        var modify_class_td = modify_class_tr.getElementsByTagName("td");
        my_form.modify_class_id.value = tr_node.getElementsByTagName("td")[0].textContent;
        modify_class_td[1].getElementsByTagName("input")[0].value = tr_node.getElementsByTagName("td")[1].textContent;
        modify_class_td[2].getElementsByTagName("input")[0].value = tr_node.getElementsByTagName("td")[2].textContent;
      }
      function cancel_class_entry_input(){
        document.location.href="/student/classes.php";
      }
      function confirm_class_entry_input(){
        my_form.submit();
      }
      function new_class_entry(){
        if(my_form.add_class_no && my_form.add_class_name){
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
      <form name="my_form" action="./classes.php" method="post">
        <input type="hidden" name="delete_from_class_id" value="">
      <table border="1" style="text-align:center">
        <tr class="tr_header">
          <th style="display:none">班级ID</th>
          <th>班级号</th>
          <th>班级名</th>
          <th>操作</th>
        </tr>
        <!--This is the Content of the table-->
<?php
    include "./database/database.php";
    $Select_Class_SQL = "select * from classes";
    $Select_Class_Result = mysqli_query($serverLink, $Select_Class_SQL);
    while($class = mysqli_fetch_array($Select_Class_Result)){
      echo "<tr class='tr_content'>";
    	echo "<td style='display:none'>".$class['class_id']."</td>";
    	echo "<td>".$class['class_no']."</td>";
    	echo "<td>".$class['class_name']."</td>";
      echo "<td><input type='button' class='delete_button' value='删除' onclick='delete_class_entry(this.parentElement.parentElement)'>";
      echo "<input type='button' class='modify_button' value='修改' onclick='modify_class_entry(this.parentElement.parentElement)'></td>";
      echo "</tr>";
    }
?>
        <!--This is the Add_Part tr of the table-->
        <tr class="tr_content_add">
          <td style="display:none"><input type="hidden" name="add_class_id"></td>
          <td><input type="text" name="add_class_no" value=""></td>
          <td><input type="text" name="add_class_name" value=""></td>
          <td><input type="button" class="add_class_button" value="添加" onclick="new_class_entry()" style="width:100%;"></td>
        </tr>
        <!--This is the Modify_Part tr of the table-->
        <tr class="tr_content_modify" style="display:none;">
          <td style="display:none"><input type="hidden" name="modify_class_id"></td>
          <td><input type="text" name="modify_class_no" value=""></td>
          <td><input type="text" name="modify_class_name" value=""></td>
          <td>
            <input type="button" class="cancel_class_button" value="取消" onclick="cancel_class_entry_input()">
            <input type="button" class="confirm_class_button" value="确认" onclick="confirm_class_entry_input()">;
          </td>
        </tr>
      </table>
    </div>

<?php
  if($_POST){
    // delete selected entry
    if($_POST["delete_from_class_id"]){
      $delete_from_class_id = $_POST["delete_from_class_id"];
      $delete_class_sql = "delete from classes where class_id=".$delete_from_class_id;
      $delete_class_sql_result = mysqli_query($serverLink, $delete_class_sql);
      if($delete_class_sql_result){
        echo "<script>alert('删除成功!')</script>";
        echo "<script>document.location.href='/student/classes.php'</script>";
      }else{
        if(mysqli_errno($serverLink)==1451){
          echo "<script>alert('嘀!执行删除指令失败，小主请留意是否其他表仍然保留本条数据');</script>";
          echo "<script>document.location.href='/student/classes.php'</script>";
        }else{
        echo "<script>alert('执行删除命令失败!');document.location.href='/student/classes.php'</script>";
        }
      }
    }
    // add new class entry
    if($_POST["add_class_no"]){
      $new_class_no = $_POST["add_class_no"];
      $new_class_name = $_POST["add_class_name"];
      $new_class_sql = "INSERT INTO classes VALUES(NULL, '".$new_class_no."', '".$new_class_name."')";
      echo "<script>alert('".$new_class_sql."')</script>";
      $new_class_sql_result = mysqli_query($serverLink, $new_class_sql) or die("<script>alert('添加失败，请检查输入并重新添加');document.location.href='/student/classes.php'</script>");
      echo "<script>alert('添加成功!');document.location.href='/student/classes.php';</script>";
    }
    // modify selected entry
    if($_POST["modify_class_no"]){
      $modify_class_no = $_POST["modify_class_no"];
      $modify_class_name = $_POST["modify_class_name"];
      $modify_class_id = $_POST["modify_class_id"];
      $modify_class_sql = "UPDATE classes  SET class_no='".$modify_class_no."', class_name='".$modify_class_name."' WHERE class_id=".$modify_class_id;
      $modify_class_sql_result = mysqli_query($serverLink, $modify_class_sql) or die("<script>alert('执行更新命令失败，请检查输入并重新提交');document.location.href='/student/classes.php'</script>");
      echo "<script>alert('更新成功!');document.location.href='/student/classes.php'</script>;";
    }
  }
?>

<?php
mysqli_free_result($Select_Class_Result);
?>
  </body>
</html>