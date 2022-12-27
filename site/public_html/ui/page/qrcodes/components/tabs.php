<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#dados_produto" aria-controls="dados_produto" role="tab" data-toggle="tab">Dados do QrCode</a></li>
    <li role="presentation"><a href="#imagem" aria-controls="imagem" role="tab" data-toggle="tab">Imagens do QrCode</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="dados_produto">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input id="name" type="text" class="form-control" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>" required>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <input id="description" type="text" class="form-control editor" name="description" value="<?php print(isset($data["description"]) ? $data["description"] : "") ?>" required>
                    </div>
                </div>

                <?php if (count($data) > 0) { ?>
                    <div class="col-lg-6">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" id="is_new" name="is_new" class="custom-control-input" aria-describedby="urlHelp">
                            <label class="custom-control-label" for="is_new">Gerar novo QRcode?</label>
                        </div>
                        <small id="urlHelp" class="form-text text-muted"><strong style="color: #B22222">Atenção:</strong> Ao gerar um novo Qrcode, o antigo será inutilizado!</small>
                    </div>
                <?php } ?>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="manuals_id">Referente ao Manual:</label>
                        <select name="manuals_id" id="manuals_id" class="form-control">
                            <option value="">Selecione</option>
                            <?php
                            foreach (manuals_controller::data4select("idx", array(" idx > 0 "), "name") as $k => $v) {
                                printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["manuals_attach"]) && $data["manuals_attach"][0]["idx"] == $k ? ' selected="selected"' : '', $v);
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="imagem">
        <div class="box box-primary">
            <div class="box-body">
                <?php if (!empty($data["url"]) && file_exists(constant("cRootServer") . $data["url"])) { ?>
                    <div class="col-lg-12">
                        <div class="media">
                            <img src="/<?php print($data["url"]) ?>" class="img-thumbnail align-self-end mr-3" alt="..." style="max-width: 20%;">
                            <div class="media-body">
                                <h5 class="mt-5">Exemplo do Qrcode gerado.</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 text-center">
                        <a name="" id="" class="btn btn-primary" href="/<?php print($data["url"]) ?>" role="button" download> Baixar QRcode</a>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Link</label>
                            <input type="text" name="" id="" class="form-control" value="<?php print(isset($data["link"]) ? $data["link"] : "") ?>" disabled>
                        </div>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </div>
</div>