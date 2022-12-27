<?php foreach ($dataTables as $table) { ?>
    <div class="col-lg-4 col-xs-4">
        <div class="small-box <?php print(isset($table["commands_attach"][0]) ? "bg-red" : "bg-green") ?>">
            <div class="inner">
                <h3>
                    <?php print($table["name"]) ?>
                </h3>

                <p>
                    <?php print("Quantidade de Lugares: " . $table["qtd_chairs"]) ?>
                </p>
            </div>
            <div class="icon">
                <i class="bi bi-file-pdf"></i>
            </div>
            <a href="/mesa/<?php print($table["idx"]) ?>" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
<?php } ?>