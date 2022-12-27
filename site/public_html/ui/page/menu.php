<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><a href="<?php print($GLOBALS["menus_url"]) ?>">Menus</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="container-fluid">
            <div class="col-lg-12">
                <h3><?php print(isset($info["idx"]) && (int)$info["idx"] > 0 ? $data["name"] : "Cadastrar Menu") ?></h3>
            </div>

            <form action="<?php print($form["url"]) ?>" method="post" enctype="multipart/form-data">
                <?php
                if (isset($info["get"]["done"]) && !empty($info["get"]["done"])) {
                ?>
                    <input type="hidden" id="done" name="done" value="<?php print($info["get"]["done"]) ?>">
                <?php
                }
                ?>

                <div class="col-lg-12 text-center mb-2 d-none" id="error_cpf"></div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informações</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputName">Nome do Menu</label>
                            <input type="text" class="form-control" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>" name="name" id="exampleInputName" placeholder="Nome do Menu">
                        </div>

                        <div class="form-group">
                            <label for="">URL</label>
                            <select class="form-control select2" name="urls_id" style="width: 100%;">
                                <option value="-1" <?php print(!isset($data["urls_attach"][0]) || $data["urls_attach"][0]["idx"] == "-1" ? " selected='selected' " : "") ?>>--- RAIZ ---</option>
                                <?php
                                foreach (urls_controller::data4select("idx", array(" idx > 0 "), "name") as $k => $v) {
                                    printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["urls_attach"][0]) && $data["urls_attach"][0]["idx"] == $k ? ' selected="selected"' : '', $v);
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPosition">Posição do Menu</label>
                            <input type="text" class="form-control" value="<?php print(isset($data["position"]) ? $data["position"] : "") ?>" name="position" id="exampleInputPosition" placeholder="Posição do Menu">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Perfis Disponiveis</label>
                            <select class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais perfis" style="width: 100%;">
                                <?php foreach (profiles_controller::data4select("idx", array(" idx > 1 and active = 'yes' "), "name") as $k => $v) { ?>
                                    <option value="<?php print($k) ?>"><?php print($v) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputIcone">Icone</label>
                            <input type="email" class="form-control" id="exampleInputIcone" placeholder="Icone do Menu">
                        </div>
                    </div>

                    <div class="box-footer text-right">
                        <button type="submit" name="btn_save" id="btn_save" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php print(isset($data["idx"]) ? " Salvar" : " Cadastrar") ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>