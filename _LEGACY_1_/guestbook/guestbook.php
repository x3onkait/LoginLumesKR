<div style="position:absolute; top: 15%; left:15%; width:70%;">

    <form action="/guestbook/addMessage.php" method="post">

        <div class="form-group">
            <label for="exampleFormControlTextarea1">π» νκ³  μΆμ λ§μ΄ μμΌμ κ°μ?</label>
            <?php
            if (isset($_SESSION['id'])) {

                ?>

                <input class="form-control" name="id" type="text" placeholder="<?php echo $_SESSION['id'] ?>" readonly>
                <textarea class="form-control" name="comment" onkeypress="submitWithShortcut(event)" id="userComment" rows="3" style="margin-bottom: 10px;" autofocus placeholder="λλ°°, μλΉμ€ κ±°λΆ κ³΅κ²©(DoS) μλ, μΈμ κ³΅κ²©, λͺ¨μ, μμ€, λΉλ°©, κ°μΈμ λ³΄ μ μΆ, κΈ°ν μ¬λ¬ μ¬μ©μμκ² λΆμΎκ°μ μ£Όλ λ±μ κ²μκΈμ μ¬λ¦¬λ νμλ λ²μ  μ²λ²μ λμμ΄ λ  μ μμΌλ©° ν΅λ³΄ μμ΄ κ²μκΈμ΄ μ κ±°λκ±°λ κ³μ μ΄ (μκ΅¬)μ μ§λ  μ μμ΅λλ€. / ~1,000 λ°μ΄νΈκΉμ§..."></textarea>

                <div class="float-right"><button type="submit" id="addUserCommentButton" class="btn btn-primary">λ©μμ§ μμ±νκΈ°</button></div>
                <div class="float-right"><button type="button" class="mx-2 btn btn-info">
                        <span id="counter">0 Bytes / 1,000 Bytes</span>
                        </button></div>

                        <p style="margin-top: 10px;">π‘ <strong>TIP</strong> : <kbd>Ctrl</kbd> + <kbd>Enter</kbd> λλ <kbd>β Command</kbd> + <kbd>Enter</kbd> λ‘ λ°λ‘ κ²μκΈμ λ±λ‘ν΄ λ³΄μΈμ.</p>
                <div class="progress" style="width: 250px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="counterProgressBar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                

                <script type="text/javascript" src="guestbook/js/guestbookTextCounter.js"></script>

                <?php

            } else {

                ?>

                <input class="form-control" name="id" type="text" placeholder="YOU\'RE NOT LOGGED IN" readonly>
                <textarea class="form-control" id="userComment" rows="3" style="margin-bottom: 10px;" placeholder="λ‘κ·ΈμΈν μ¬μ©μλ§ κ²μκΈμ λ¨κΈΈ μ μμ΄μ." readonly></textarea>
                <div class="float-right"><button type="submit" class="btn btn-primary" disabled>λ°©λͺλ‘ μμ±νκΈ°</button></div>

                <?php

            }
            
        ?>
        </div>

    </form>

    <?php include("showMessage.php") ?>


</div>

<script>

    let userInputMessageBox  = document.getElementById('userComment');
    let addUserCommentButton = document.getElementById('addUserCommentButton');

    function submitWithShortcut(e){

        // [Ctrl] + [Enter] λλ [β Command] + [Enter] λ¨μΆ μ‘°ν©ν€ μΈνΈλ₯Ό λλ₯΄λ©΄ λ°λ‘ μ μ‘
        if((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)){
            addUserCommentButton.click();
        }
    }

</script>