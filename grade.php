<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>grade</title>
</head>
<body>
    
<form action='<?=$_SERVER['PHP_SELF'];?>' method='POST'>
    กรุณากรอกคะแนน <input type='text' name='score'><br/>
    <input type='submit' value='ตัดเกรด'>
</form>

<?php

    isset( $_POST['score'] ) ? $score = $_POST['score'] : $score = 0;

    if( $score > 0 ) {
        $grade = "E";
        if( $score >= 90 ) {
            $grade = "A";
        } else if( $score >= 80 ) {
            $grade = "B";
        } else if( $score >= 70 ) {
            $grade = "C";
        } else if( $score >= 60 ) {
            $grade = "D";
        } else {
            $grade = "E";
        }

        echo "คะแนน {$score} คุณได้รับเกรด {$grade}";
    }
?>
</body>
</html>