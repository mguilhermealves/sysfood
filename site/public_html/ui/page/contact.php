<main class="container-fluid">
    <section class="banners-contacts">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 banners-contacts-imagem">
                    <label id="texto-banners-contacts">
                        Contato
                    </label>
                </div>
            </div>
        </div>
    </section>

    <section class="form-contacts">
        <div class="container padding-50">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php html_notification_print(); ?>
                    <div class="row">
                        <form action="/enviar_contato" method="post">
                            <div class="row padding-top-50 padding-bottom-50">
                                <div class="col-6 padding-right-10">
                                    <div class="form-group">
                                        <label for="">Nome*</label>
                                        <input type="text" name="name" id="" class="form-control form-control-contacts" placeholder="">
                                    </div>
                                </div>

                                <div class="col-6 padding-right-10">
                                    <div class="form-group">
                                        <label for="">Telefone*</label>
                                        <input type="text" name="phone" id="" class="form-control form-control-contacts" placeholder="">
                                    </div>
                                </div>

                                <div class="col-6 padding-right-10">
                                    <div class="form-group">
                                        <label for="">E-mail*</label>
                                        <input type="text" name="mail" id="" class="form-control form-control-contacts" placeholder="">
                                    </div>
                                </div>

                                <div class="col-6 padding-right-10">
                                    <div class="form-group">
                                        <label for="">Assunto*</label>
                                        <input type="text" name="subject" id="" class="form-control form-control-contacts" placeholder="">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control form-control-contacts" name="description" id="" rows="6" placeholder="Conte aqui como podemos te ajudar" style="resize: none;"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row">
                        <div class="col-12 margin-top-50 margin-left-70 xs-margin-left-0">
                            <button type="button" id="btn-sc" class="btn btn-primary">Santa Catarina</button>
                            <button type="button" id="btn-sp" class="btn btn-primary">São Paulo</button>
                            <button type="button" id="btn-ch" class="btn btn-primary">Shenzhen</button>
                        </div>
                        <div class="col-12 margin-top-20 margin-left-70 xs-margin-left-0 iframe-rwd" id="sc-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3557.970919770456!2d-48.657227299999995!3d-26.904417999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94d8cc0d6acd9e2d%3A0x8197f2387ac3abf8!2sR.%20Manoel%20Vi%C3%AAira%20Gar%C3%A7%C3%A3o%20-%20Centro%2C%20Itaja%C3%AD%20-%20SC%2C%2088301-425!5e0!3m2!1spt-BR!2sbr!4v1667274976989!5m2!1spt-BR!2sbr" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-12 d-none margin-top-20 margin-left-70 xs-margin-left-0 iframe-rwd" id="sp-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3655.4289275768797!2d-46.706406084422426!3d-23.6248053698247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce50dc00617f19%3A0xd1772e507b3dbf11!2sAv.%20das%20Na%C3%A7%C3%B5es%20Unidas%2C%2014401%20-%20Ch%C3%A1cara%20Santo%20Ant%C3%B4nio%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2004794-000!5e0!3m2!1spt-BR!2sbr!4v1667275775341!5m2!1spt-BR!2sbr" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-12 d-none margin-top-20 margin-left-70 xs-margin-left-0 iframe-rwd" id="ch-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d235816.84355979523!2d113.76679041855493!3d22.555222657660966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3403f408d0e15291%3A0xfdee550db79280c9!2sShenzhen%2C%20Guangdong%2C%20China!5e0!3m2!1spt-BR!2sbr!4v1667275954540!5m2!1spt-BR!2sbr" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>