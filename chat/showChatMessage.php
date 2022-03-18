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

                ?>

                    <tr>
                        <td style="vertical-align : top;"> <img src="<?php echo $profilePicturePath ?>" class="profileImage"> </td>
                        <td style="width: 20%; padding-left: 15px; vertical-align : top;">

                            <?php
                                if($writer_role === "Admin"){
                            ?>
                                    <span style="font-weight: bold;"><?php echo $writer_id ?></span>
                                    <span class="badge badge-pill badge-primary">Admin</span><br>

                            <?php 
                                } else if($writer_role === "QA") {
                            ?>

                                    <span style="font-weight: bold;"><?php echo $writer_id ?></span>
                                    <span class="badge bg-dark" style="color: white;">QA</span><br>

                            <?php
                                } else {
                            ?>

                                    <span style="font-weight: bold;"><?php echo $writer_id ?></span><br>

                            <?php
                                }
                            ?>
                            
                            <span style="color: gray;"><?php echo $writer_nickname ?></span>

                        </td>

                        <td style="width: 80%;"> 
                            <span style="color: gray; font-size: 0.75em"><?php echo $date ?></span><br>
                            <span><?php echo $content ?></span>
                        </td>

                    </tr>

                <?php
                
            }
        echo '</table>';

    echo '</div>';

?>