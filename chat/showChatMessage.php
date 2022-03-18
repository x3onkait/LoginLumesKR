<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN.LUMES.KR</title>
    <link rel="shortcut icon" href="/favicon/logo.png">
    <link rel="stylesheet" href="./css/showChatMessage.css">

</head>

<body>
    <!-- 프로세스 처리 구간이라서 굳이 뭘 할 건 없음. -->
</body>

<?php

    session_start();
    header('Content-Type: text/html; charset=utf-8');

    // DB connection
    require(dirname(__FILE__) . "/../dbconnection.php");

    $query = "SELECT * FROM chat WHERE message_room = 'public' ORDER BY idx ASC LIMIT 100";
    $rawChatData = mysqli_query($conn, $query);

    echo '<div id="userLiveChatTable">';
        echo '<table>';

            while($row = mysqli_fetch_array($rawChatData)) {

                $idx                = $row['idx'];
                $writer_id          = $row['writer_id'];
                $writer_nickname    = $row['writer_nickname'];
                $content            = $row['content'];
                $date               = $row['date'];
                $writer_role        = $row['writer_role'];

                $profilePicturePath     = "../_serverasset/_userProfilePictures/" . "profilePic_" . "$writer_id" . ".jpg";
                if(file_exists($profilePicturePath) === false){
                    // default profile picture
                    $profilePicturePath = "../_serverasset/_defaultProfilePictures/_defaultProfileImage.jpg";
                }

                echo '<tr>';
                    echo '<td><img src="' . $profilePicturePath . '" class="profileImage"></td>';
                    echo '<td style="width: 20%;"><strong>' . $writer_id . '<br></strong>(' . $writer_nickname . ')</td>';
                    echo '<td style="width: 60%;">' . $content . '</td>';
                    echo '<td>' . $date . '</td>';
                echo '</tr>';

                
            }
        echo '</table>';
    echo '</div>';

?>