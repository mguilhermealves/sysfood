<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#dados_produto" aria-controls="dados_produto" role="tab" data-toggle="tab">Dados do Manual</a></li>
    <li role="presentation"><a href="#pdf" aria-controls="pdf" role="tab" data-toggle="tab">Manual em PDF</a></li>
    <!-- <li role="presentation"><a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">Manual Video</a></li> -->
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="dados_produto">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input id="name" type="text" class="form-control" name="name" value="<?php print(isset($data["name"]) ? $data["name"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="is_video">Video é um arquivo?</label>
                        <select name="is_video" id="is_video" class="form-control">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($GLOBALS["yes_no_lists"] as $k => $v) {
                                printf('<option %s value="%s">%s</option>', isset($data["is_video"]) && $k == $data["is_video"] ? ' selected' : '', $k, $v);
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="video">Link do Video:</label>
                        <input id="video" type="text" class="form-control" name="video" value="<?php print(isset($data["video"]) ? $data["video"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="uploader">
                        <input type="file" id="file-upload" name="manual_img" value="<?php print(isset($data["manual_img"]) ? $data["manual_img"] : "") ?>">

                        <label for="file-upload" id="file-drag" class="margin-bottom-50">
                            <img class="img-fluid" id="file-image" src="<?php print(isset($data["manual_img"]) ? constant("cFrontend") . $data["manual_img"] : ""); ?>" alt="Preview" class="<?php isset($data["manual_img"]) ? "" : "hidden" ?>">

                            <div id="start">
                                <i class="bi bi-cloud-upload" aria-hidden="true"></i>
                                <div>Selecione o arquivo de Imagem ou Arraste uma imagem dentro da área</div>
                                <div id="notimage" class="hidden">Selecione a imagem</div>
                            </div>

                            <div id="response" class="hidden">
                                <!-- <div id="messages"></div> -->
                            </div>
                        </label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="description">Descrição Português:</label>
                        <input id="description" type="text" class="form-control editor" name="description" value="<?php print(isset($data["description"]) ? $data["description"] : "") ?>" required>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="description_ingles">Descrição Inglês:</label>
                        <input id="description_ingles" type="text" class="form-control editor" name="description_ingles" value="<?php print(isset($data["description_ingles"]) ? $data["description_ingles"] : "") ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="pdf">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="description">PDF:</label>
                        <input type="file" name="manual_pdf" id="manual_pdf" accept="application/pdf">
                    </div>
                </div>

                <div class="col-12 col-lg-12">
                    <?php if (isset($data["manual_pdf"])) {
                        $pdf = unserialize($data["manual_pdf"]); ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <iframe class="pdf" src="/<?php print($pdf) ?>" width="100%" height="500px"></iframe>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .uploader {
        display: block;
        clear: both;
        margin: 0 0 50px 0 auto;
        width: 100%;
    }

    .uploader label {
        float: left;
        clear: both;
        width: 100%;
        padding: 2rem 1.5rem;
        margin-bottom: 50px;
        text-align: center;
        background: #F5F5F5;
        border-radius: 7px;
        border: 3px solid #eee;
        transition: all 0.2s ease;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .uploader label:hover {
        border-color: #454cad;
        margin-bottom: 50px;
    }

    .uploader label.hover {
        border: 3px solid #454cad;
        box-shadow: inset 0 0 0 6px #eee;
    }

    .uploader label.hover #start i.fa {
        transform: scale(0.8);
        opacity: 0.3;
    }

    .uploader #start {
        float: left;
        clear: both;
        width: 100%;
    }

    .uploader #start.hidden {
        display: none;
    }

    .uploader #start i {
        font-size: 50px;
        margin-bottom: 1rem;
        transition: all 0.2s ease-in-out;
    }

    .uploader #response {
        float: left;
        clear: both;
        width: 100%;
    }

    .uploader #response.hidden {
        display: none;
    }

    .uploader #response #messages {
        margin-bottom: 0.5rem;
    }

    .uploader #file-image {
        display: inline;
        margin: 0 auto 0.5rem auto;
        width: auto;
        height: auto;
        max-width: 500px;
    }

    .uploader #file-image.hidden {
        display: none;
    }

    .uploader #notimage {
        display: block;
        float: left;
        clear: both;
        width: 100%;
    }

    .uploader #notimage.hidden {
        display: none;
    }

    .uploader progress,
    .uploader .progress {
        display: inline;
        clear: both;
        margin: 0 auto;
        width: 100%;
        max-width: 180px;
        height: 8px;
        border: 0;
        border-radius: 4px;
        background-color: #eee;
        overflow: hidden;
    }

    .uploader .progress[value]::-webkit-progress-bar {
        border-radius: 4px;
        background-color: #eee;
    }

    .uploader .progress[value]::-webkit-progress-value {
        background: linear-gradient(to right, #393f90 0%, #454cad 50%);
        border-radius: 4px;
    }

    .uploader .progress[value]::-moz-progress-bar {
        background: linear-gradient(to right, #393f90 0%, #454cad 50%);
        border-radius: 4px;
    }

    .uploader input[type=file] {
        display: none;
    }

    .uploader div {
        margin: 0 0 0.5rem 0;
        color: #5f6982;
    }

    .uploader .btn {
        display: inline-block;
        margin: 0.5rem 0.5rem 1rem 0.5rem;
        clear: both;
        font-family: inherit;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        text-transform: initial;
        border: none;
        border-radius: 0.2rem;
        outline: none;
        padding: 0 1rem;
        height: 36px;
        line-height: 36px;
        color: #fff;
        transition: all 0.2s ease-in-out;
        box-sizing: border-box;
        background: #454cad;
        border-color: #454cad;
        cursor: pointer;
    }
</style>