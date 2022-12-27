<nav class="navbar navbar-expand-lg navbar-light bg-light nav-custom">
    <a class="navbar-brand" href="#">
        <img class="img-fluid navbar-logo" src="<?php printf("%s%s", constant("cFurniture"), "images/logo-dermolaser.png") ?>">
    </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link nav-link-custom" href="<?php print($GLOBALS["home_url"]) ?>" role="button">
                    <i class="bi bi-house-door"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-custom" href="<?php print($GLOBALS["depilacaoLaser_url"]) ?>">Depilação a Laser</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-custom" href="<?php print($GLOBALS["depilacaoFacial_url"]) ?>">Tratamento Facial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-link-custom" href="<?php print($GLOBALS["tratamentosCorporais_url"]) ?>">Tratamento Corporal</a>
            </li>
        </ul>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link nav-link-custom" href="<?php print($GLOBALS["units_url"]) ?>">Unidades </a>
            </li>
        </ul>
    </div>
</nav>