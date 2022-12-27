<body class="hold-transition login-page">

    <?php
    if (isset($_SESSION[constant("cAppKey")]["messages"])) {
        foreach ($_SESSION[constant("cAppKey")]["messages"] as $k => $v) {
            printf('<div class="alert alert-%s" >%s</div>', $k, implode("<br>", $v));
        }
        unset($_SESSION[constant("cAppKey")]["messages"]);
    }
    ?>

    <div class="login-box">
        <div class="login-logo">
            <img class="img-fluid" src="<?php printf("%s%s", constant("cFurniture"), "img/logo.png") ?>" style="max-width: 300px; margin:0 auto; float:none">
        </div>

        <form action="<?php print($GLOBALS["home_url"]) ?>" method="POST">
            <input type="hidden" value="1" name="auth_code_send" />

            <h4>Enviamos um código de acesso para:</h4>
            <strong><?php print($mail) ?></strong><br><br>


            <label for="authenticator">Insira seu token:</label>
            <input type="text" name="code_auth" id="code_auth" class="form-control" placeholder="Ex: 0000" required>
            <br>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" name="btn_save" class="btn btn-primary btn-block btn-flat">Verificar</button>
                </div>
            </div>

        </form>

        <br>

        <div class="form-group py-3">
            <div class="d-flex flex-column input-group-prepend padding-right-15 padding-left-15">
                <button id="buttonResend" type="button" class="btn btn-block form-control " disabled style="color: #fff;background-color: #008fbb;">
                    Reenviar&nbsp;&nbsp;&nbsp;&nbsp; <span id="sendCont">(60)</span></button>
            </div>
        </div>
</body>