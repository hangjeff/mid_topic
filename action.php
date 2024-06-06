<?php
if (is_null($_POST["mail"]) or $_POST["mail"] == "") {
    echo "<script>alert('請填信箱');</script>";
    header("Location: contact.html");
    die();
} else {
    // 建立MySQL的資料庫連接 
    $link = @mysqli_connect(
        'localhost',  // MySQL主機名稱 
        'root',       // 使用者名稱 
        '',  // 密碼 
        'midtopic_order'
    );  // 預設使用的資料庫名稱 
    if (!$link) {
        echo "MySQL資料庫連接錯誤!<br/>";
        exit();
    } else {
        $nowTime = date("Y-m-d H:i:s");
        $sqlMsg = mysqli_query(
            $link,
            "INSERT INTO mt_order VALUES('" . $_POST["name"] . "', '" . $_POST["mail"] . "', " . strval($_POST["sbc"]) .
            ", " . strval($_POST["clc"]) . ", " . strval($_POST["fr"]) . ", " . strval($_POST["flash"]) . ", " .
            strval($_POST["mb"]) . ", " . strval($_POST["horse"]) . ", " . strval($_POST["eu"]) . ", " . strval($_POST["mdl"]) .
            ", " . strval($_POST["klee"]) . ", '" . $nowTime . "' );"
        );
        $result = mysqli_query(
            $link,
            "SELECT * FROM mt_order WHERE 電子信箱 = '"  . $_POST["mail"] . "' AND 時間 = '" . $nowTime . "';"
        );
    }
    echo "訂單傳送完成！<br><br>";
    while( $row = mysqli_fetch_assoc($result) ) {
        if($_POST['mail'] == $row['電子信箱'] && $nowTime == $row['時間']){
            $item = ['姓名', '電子信箱', '草莓蛋糕', '巧克力蛋糕', '法式千層酥',
            '閃電泡芙', '蒙布朗', '馬卡龍', '歐培拉', '瑪德蓮', '可麗露', '時間'];
            for($i = 0; $i < count($item) - 1; $i++){
                echo $item[$i] . ' : ' . $row[$item[$i]] . '<br>';
            }
        }
    }
    mysqli_close($link);  // 關閉資料庫連接
}

?>