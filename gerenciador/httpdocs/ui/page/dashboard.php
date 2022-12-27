<!-- Container Begin -->
<div class="row">
    <div class="large-12 columns" >
        <div class="box solaris-header">
            <div class="box-header bg-transparent">
                <!-- tools box -->
                <h3 class="box-title">
                    <span>Dashboard</span>
                </h3>
            </div>
        </div>
        <div class="box solaris-head">
            <div class="box-header bg-transparent">
                <h3>
                    <span>Usuários</span>
                </h3>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                    include( constant("cRootServer") . "ui/common/resume.php");
                ?>
            </div>
            <!-- end .timeline -->
        </div>
        <!-- box -->
    </div>
</div>

<style>
    .cp{ margin-top:12px; margin-bottom:12px }
    .cp .well{ border:1px solid #c0c0c0; padding:9px; height:100%; }
    .cp .well p{ min-height:65px; }

    .cp .well img{ transition: 0.3s; }
    .cp .well img:hover {opacity: 0.7;}

    .modal { display: none; position: fixed; z-index: 2000; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.9); }
    .modal-content { margin: auto; display: block; width: 75%; max-width: 600px; }
    #caption { margin: auto; display: block; width: 75%; max-width: 600px; text-align: center; color: #ccc; padding: 10px 0; height: 150px; }
    .modal-content, #caption {   -webkit-animation-name: zoom; -webkit-animation-duration: 0.6s; animation-name: zoom; animation-duration: 0.6s; }
@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}
@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}
.close { position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; transition: 0.3s; }
.close:hover, .close:focus { color: #bbb; text-decoration: none; cursor: pointer; }
@media only screen and (max-width: 700px){
  .modal-content { width: 100%; }
}
</style>