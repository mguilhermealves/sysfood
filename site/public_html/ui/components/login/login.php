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

        <div class="login-box-body">
            <p class="login-box-msg">Faça o Login para acessar o sistema.</p>

            <form action="<?php print($GLOBALS["home_url"]) ?>" method="post">
                <div class="form-group has-feedback">
                    <input type="text" name="login" class="form-control" placeholder="Digite seu Login" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Digite sua Senha" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <a href="<?php print($GLOBALS["forgot_password_url"]) ?>">Esqueci a senha</a>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" name="btn_save" class="btn btn-primary btn-block btn-flat">Acessar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>