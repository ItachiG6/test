<?php 
//ไฟล์เชื่อมต่อฐานข้อมูล
    require_once 'connect.php';
 ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Basic PHP PDO ระบบเพิ่มข้อมูลพนักงาน by devbanban.com 2021</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8"> <br> 
          <h5>PHP PDO :: ระบบเพิ่มข้อมูลพนักงาน : Insert Data & Inner Join</h5>

          <form action="" method="post">
            <div class="mb-2 row">
                <div class="col-sm-6">
                <select name="ref_p_id" class="form-control" required>
                  <option value="">-เลือกตำแหน่งงาน-</option>
                  <?php
                  //คิวรี่ข้อมูลตำแหน่ง เพื่อมาแสดงใน select/option
                  $stmt = $conn->prepare("SELECT* FROM tbl_position");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                  foreach($result as $row) {
                  ?>
                  <option value="<?= $row['p_id'];?>">-<?= $row['p_name'];?></option>
                <?php } ?>
                </select>
              </div>
               <div class="col-sm-6">
                  <input type="text" name="xxx" class="form-control" required  placeholder="อื่นๆ ตาม Requirements..." disabled>
                </div>
              </div>
            <div class="mb-2 row">
                <div class="col-sm-6">
                <input type="text" name="emp_name" class="form-control" required minlength="3" placeholder="ชื่อ">
              </div>
             <!--  </div>
              <div class="mb-2"> -->
                <div class="col-sm-6">
                  <input type="text" name="emp_surname" class="form-control" required minlength="3" placeholder="นามสกุล">
                </div>
                </div>
                <div class="mb-2 row">
                <div class="col-sm-6">
                  <input type="text" name="emp_phone" class="form-control" required minlength="10" maxlength="10" placeholder="เบอร์โทร">
                </div>
                <div class="col-sm-6">
                  <input type="text" name="xxx" class="form-control" required  placeholder="อื่นๆ ตาม Requirements..." disabled>
                </div>
                </div>
                <div class="mb-2 row">
                <div class="d-grid gap-2 col-sm-12 mb-3">
                <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
              </div>
            </div>
              </form>

              <h5>รายชื่อพนักงาน</h5>
               <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="25%">ตำแหน่ง</th>
                                <th width="25%">ชื่อ</th>
                                <th width="25%">นามสกุล</th>
                                <th width="20%">เบอร์โทร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //คิวรี่ข้อมูลมาแสดงในตาราง โดยเทียบข้อมูลระหว่างตารางตำแหน่งงานกับตารางพนักงานที่มีคอลัมภ์สัมพันธ์กัน ก็คือ p_id กับ ref_p_id
                            $stmtEmp = $conn->prepare("
                              SELECT e.*, p.p_name #ตารางพนักงานเอามาทุกคอลัมภ์ , ตารางตำแหน่งเอามาแค่ชื่อตำแหน่ง
                              FROM tbl_emp AS e  #AS e คือการแทนชื่อตารางให้ชื่อสั้นลงในตอนที่เอาไป inner join โค้ดจะดูไม่รก
                              INNER JOIN tbl_position AS P ON e.ref_p_id=p.p_id
                              ORDER BY e.no ASC #เรียงลำดับข้อมูลจากน้อยไปมาก
                              ");
                            $stmtEmp->execute();
                            $resultEmp = $stmtEmp->fetchAll();
                            foreach($resultEmp as $rowEmp) {
                            ?>
                            <tr>
                                <td><?= $rowEmp['no'];?></td>
                                <td><?= $rowEmp['p_name'];?></td>
                                <td><?= $rowEmp['emp_name'];?></td>
                                <td><?= $rowEmp['emp_surname'];?></td>
                                <td><?= $rowEmp['emp_phone'];?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
          </div>
        </div>
     
      </body>
    </html>  


    <?php

  //print_r($_POST); //ตรวจสอบมี input อะไรบ้าง และส่งอะไรมาบ้าง 
  //exit();
 //ถ้ามีค่าส่งมาจากฟอร์ม
    if(isset($_POST['emp_name']) && isset($_POST['emp_surname']) && isset($_POST['emp_phone']) && isset($_POST['ref_p_id'])){
    // sweet alert 
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

    //ไฟล์เชื่อมต่อฐานข้อมูล
    //require_once 'connect.php';
    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $ref_p_id = $_POST['ref_p_id'];
    $emp_name = $_POST['emp_name'];
    $emp_surname = $_POST['emp_surname'];
    $emp_phone = $_POST['emp_phone'];

    //check duplicate เช็คขากชื่อ-นามสกุล
      $stmt = $conn->prepare("SELECT no FROM tbl_emp WHERE emp_name = :emp_name AND emp_surname = :emp_surname");
      $stmt->execute(array(':emp_name' => $emp_name, ':emp_surname' => $emp_surname ));
      //ถ้าชื่อ-นามสกุลซ้ำ ให้เด้งกลับไปหน้าฟอร์ม ปล.ข้อความใน sweetalert ปรับแต่งได้ตามความเหมาะสม
      if($stmt->rowCount() > 0){
          echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "รายชื่อซ้ำ !! ",  
                            text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "formAddEmp.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                </script>';
      }else{ //ถ้าไม่ซ้ำ เก็บข้อมูลลงตาราง
              //sql insert
              $stmt = $conn->prepare("INSERT INTO tbl_emp 
                (ref_p_id, emp_name, emp_surname, emp_phone)
                VALUES 
                (:ref_p_id, :emp_name, :emp_surname, :emp_phone)");

              //brndParam ข้อความทั่วไป = PARAM_STR, ตัวเลข = PARAM_INT
              $stmt->bindParam(':emp_name', $emp_name, PDO::PARAM_STR);
              $stmt->bindParam(':emp_surname', $emp_surname , PDO::PARAM_STR);
              $stmt->bindParam(':emp_phone', $emp_phone , PDO::PARAM_STR);
              $stmt->bindParam(':ref_p_id', $ref_p_id , PDO::PARAM_INT);
              $result = $stmt->execute();
              $conn = null; //close connect db
              if($result){
                  echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เพิ่มข้อมูลพนักงานสำเร็จ",
                            type: "success"
                        }, function() {
                            window.location = "formAddEmp.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
              }else{
                 echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "formAddEmp.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
              }
             
        } //else chk dup
    } //isset 
    //devbanban.com
    ?>