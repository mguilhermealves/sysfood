<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#client" aria-controls="client" role="tab" data-toggle="tab">Identificação</a></li>
    <li role="presentation"><a href="#products" aria-controls="products" role="tab" data-toggle="tab">Produtos</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="client">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="name">Nome do Cliente:</label>
                        <input id="name" type="text" class="form-control" name="name" value="<?php print(isset($data["commands_attach"][0]) ? $data["commands_attach"][0]["client_name"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="qtd_chairs">Quantidade de Lugares:</label>
                        <input id="qtd_chairs" type="number" class="form-control" name="qtd_chairs" min="0" max="<?php print($data["qtd_chairs"]) ?>" value="<?php print(isset($data["commands_attach"][0]["qtd_chairs"]) ? $data["commands_attach"][0]["qtd_chairs"] : "") ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="products">
        <div class="box box-primary">
            <div class="box-body">
                Produtos aqui
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