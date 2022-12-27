<section class="content-header">
    <h1>
        Dashboard
        <small>Painel de Controle</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- CARDS -->
        <?php include(constant("cRootServer") . "ui/components/dashboard/cards/cards.php"); ?>
    </div>

    <div class="row">
        <hr>
        <h1>Mesas</h1>
        <!-- TABLES -->
        <?php include(constant("cRootServer") . "ui/components/dashboard/tables/tables.php"); ?>
    </div>
</section>