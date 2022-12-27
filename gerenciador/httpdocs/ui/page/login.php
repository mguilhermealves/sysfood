<div class="inner-wrap">
    <div class="wrap-fluid">
        <br>
        <br>
        <!-- Container Begin -->
        <div class="large-offset-4 large-4 columns">
            <div class="box padding-top-25">
                <!-- Profile -->
                <div class="profile" style="text-align:center">
                    <img src="<?php printf("%s%s", constant("cFurniture"), "img/logo-dermolaser.png") ?>" style="width: 156px; margin:0 auto; float:none">
                </div>
                <!-- End of Profile -->
                <!-- /.box-header -->
                <div class="box-body " style="display: block;">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row">
                                <div class="edumix-signup-panel">
                                    <form action="<?php print($GLOBALS["home_url"]) ?>" method="post">
                                        <div class="row collapse">
                                            <div class="small-2  columns">
                                                <span class="prefix bg-gray"><i class="text-white icon-user"></i></span>
                                            </div>
                                            <div class="small-10  columns">
                                                <input type="text" name="login" placeholder="Usuario">
                                            </div>
                                        </div>
                                        <div class="row collapse">
                                            <div class="small-2 columns ">
                                                <span class="prefix bg-gray"><i class="text-white icon-lock"></i></span>
                                            </div>
                                            <div class="small-10 columns ">
                                                <input type="password" name="password" placeholder="Senha">
                                            </div>
                                        </div>
                                        <div class="row collapse">
                                            <button type="submit" name="btn_save" class="button radius small expand bg-gray">Logar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end .timeline -->
            </div>
            <!-- box -->
        </div>
    </div>
    <!-- End of Container Begin -->
</div>
<!-- end paper bg -->
<!-- end of inner-wrap -->
<style>
    body {
        background: #2c3089 !important;
    }

    .bg-gray {
        background-color: #2F017B !important;
        border:1px solid #ffffff;
    }
    .box{
        background:#fff0;
        border: 2px solid #fff;
    }
</style>