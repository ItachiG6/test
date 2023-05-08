<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <title>Basic CRUD PHP PDO </title>
    </head>
    <body>
    <?php
	ini_set('display_errors', 1);
	error_reporting(~0);

	$strKeyword = null;

	if(isset($_POST["txtKeyword"]))
	{
		$strKeyword = $_POST["txtKeyword"];
	}
?>
<div class="container mb-3">
<br>
    <form name="frmSearch" method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>">
    <table width="599" >
        <tr>
        <th>Keyword
        <input name="txtKeyword" type="text" id="txtKeyword" value="<?php echo $strKeyword;?>">
        <input type="submit" value="Search"></th>
        </tr>
    </table>
    </form>
</div>


<?php

require_once 'connect.php';
	
   $sql = "SELECT * FROM tbl_member 
           INNER JOIN tbl_position ON tbl_member.p_id = tbl_position.p_id
           WHERE Name LIKE '%".$strKeyword."%' ";

   $stmt = $conn->prepare($sql);
   $stmt->execute();
    // var_dump($stmt);
    // exit;
?>
        <div class="container">
            <div class="row">
                <div class="col-md-12"> <br>
                    <h3>รายการสมาชิก <a href="formAdd.php" class="btn btn-info">+เพิ่มข้อมูล</a> </h3>
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="5%">id_emp</th>
                                <th width="40%">ชื่อ</th>
                                <th width="45%">นามสกุล</th>
                                <th width="45%">ชื่อตำแหน่ง</th>
                                <th width="5%">แก้ไข</th>
                                <th width="5%">ลบ</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($result = $stmt->fetch( PDO::FETCH_ASSOC ))
                        {
                        ?>
                            <tr>
                                <td><?= $result['id'];?></td>
                                <td><?= $result['p_id'];?></td>
                                <td><?= $result['name'];?></td>
                                <td><?= $result['surname'];?></td>
                                <td><?= $result['p_name'];?></td>
                                <td><a href="formEdit.php?id=<?= $result['id'];?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                                <td><a href="del.php?id=<?= $result['id'];?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ลบ</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
$conn = null;
?>
    </body>
</html>
