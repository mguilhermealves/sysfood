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
            <img class="img-fluid" src="<?php printf("%s%s", constant("cFurniture"), "img/white_logo.jpg") ?>"
                style="max-width: 300px; margin:0 auto; float:none">

            <h1>
                <b>H-FIN</b>
            </h1>
        </div>

        <form action="<?php print($GLOBALS["forgot_password_url"]) ?>" method="post">

            <label for="exampleInputEmail1" class="text-center">Digite seu e-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Insira seu e-mail"
                pattern=".+@hsolmkt.com.br" required>
            <br>
            <a href="<?php print($GLOBALS["home_url"]) ?>">
                <button type="button" class="btn btn-danger">Voltar</button>
            </a>

            <button type="submit" class="btn btn-primary" name="btn_save">Recuperar Senha</button>

        </form>



</body>