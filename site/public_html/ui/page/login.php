<div class="container-fluid h-100">
    <div class="row h-100 align-items-start">
        <form action="<?php print($GLOBALS["login_url"]) ?>" method="POST" class="col-xs-12 col-md-6 col-sm-6 offset-lg-2 col-lg-4 offset-xl-3 col-xl-3 auth-page align-self-center mt-2">
            <div class="auth-form">
                <?php html_notification_print() ?>
                <div class="col-8 mx-auto">
                    <img src="/furniture/images/login/logo.png" class="img-fluid">
                </div>

                <p class="lead">
                    Bem Vindos! Entre com seu login e senha para entrar no sistema.
                </p>

                <div class="form-body">
                    <div class="pt-3 form-group">
                        <label for="LabelLogin">Login:</label>
                        <input type="text" name="login" id="LabelLogin" class="form-control" placeholder="Login" autocomplete="off" aria-describedby="helpId">
                    </div>

                    <div class="pt-3 form-group">
                        <label for="LabelPassword">Senha:</label>
                        <input type="password" name="password" id="LabelPassword" class="form-control" placeholder="Senha" autocomplete="off" aria-describedby="helpId">
                    </div>
                    <div class="pt-3 row form-group">
                        <div class="col-8">
                            <div class="reset-password">
                                <a style="color:#000000;font-size:0.7rem" href="<?php print($GLOBALS["password_url"]) ?>">Esqueceu sua senha? <u>Clique Aqui.</u></a>
                            </div>
                        </div>
                        <div class="col-4" style="text-align:right">
                            <button type="submit" class="btn btn-success btn-acessar">Acessar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>    
        <div class="d-none d-sm-block col-md-6 col-sm-6 col-lg-6 col-xl-6 h-100 img"></div>
        <div class="d-block d-sm-none col-xs-12 pt-3">
            <img src="/furniture/images/login/produtos.png" class="img-fluid">
        </div>
        <div class="row">
            <div class="col-lg-12 text-center copyright p-3">
                Todos os direitos reservados | 2022 | Desenvolvido por HSOL Marketign de resultados 
            </div>
        </div>
    </div>
</div>
<style>
    body {
        background: url(/furniture/images/login/fundo_login.png) repeat-x;
        background-position: top center;
        background-size: cover;
        background-color: #F5F5F5;
    }
    .img{ 
        background: url('/furniture/images/login/img-login.png') center 15px no-repeat transparent;
        background-size: contain;
    }
    .container-fluid.h-100{
        height: calc(100% - 32px) !important;
    }
    
</style>