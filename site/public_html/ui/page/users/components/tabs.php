<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#cadastro" aria-controls="cadastro" role="tab"
            data-toggle="tab">Dados Cadastrais</a></li>
    <li role="presentation"><a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab">Endereço</a></li>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="cadastro">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="first_name">Nome:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="Ex: Marcos Guilherme"
                            value="<?php print(isset($data["first_name"]) ? $data["first_name"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="last_name">Sobrenome:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Ex: Alves da Silva"
                            value="<?php print(isset($data["last_name"]) ? $data["last_name"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control cpf" id="cpf" name="cpf" placeholder="Ex: 000.000.000-00"
                            value="<?php print(isset($data["cpf"]) ? $data["cpf"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="mail">E-mail:</label>
                        <input type="text" class="form-control mail" id="mail" name="mail"
                            placeholder="admnistrador@hsolmkt.com.br" pattern=".+@hsolmkt.com.br"
                            value="<?php print(isset($data["mail"]) ? $data["mail"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="login">Login:</label>
                        <input type="text" class="form-control login" id="login" name="login"
                            placeholder=""
                            value="<?php print(isset($data["login"]) ? $data["login"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="mail">Senha:</label>
                        <input type="password" class="form-control password" id="password" name="password"
                            value="<?php print(isset($data["password"]) ? $data["password"] : "") ?>" minlength="6">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="birthdate">Data de Nascimento:</label>
                        <input type="date" class="form-control birthdate" id="birthdate" name="birthdate"
                            placeholder="Ex: 01/01/1990"
                            value="<?php print(isset($data["birthdate"]) ? $data["birthdate"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="genre">Gênero: </label>
                        <select class="form-control select2" id="genre" name="genre" style="width: 100%;">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($GLOBALS["genre_lists"] as $k => $v) {
                                printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["genre"]) && $data["genre"] == $k ? ' selected="selected"' : '', $v);
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="profiles_id">Perfil: </label>
                        <select class="form-control select2" id="profiles_id" name="profiles_id" style="width: 100%;">
                            <option value="">Selecione</option>
                            <?php
                            foreach (profiles_controller::data4select("idx", array(" idx > 0 "), "name") as $k => $v) {
                                printf('<option value="%s"%s>%s</option>' . "\n", $k, isset($data["profiles_attach"][0]) && $data["profiles_attach"][0]["idx"] == $k ? ' selected="selected"' : '', $v);
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="endereco">
        <div class="box box-primary">
            <div class="box-body">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="postalcode">CEP:</label>
                        <input type="text" class="form-control postalcode" id="postalcode" name="postalcode"
                            placeholder="Ex: 00000-000"
                            value="<?php print(isset($data["postalcode"]) ? $data["postalcode"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="address">Endereço:</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder=""
                            value="<?php print(isset($data["address"]) ? $data["address"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="number">N°:</label>
                        <input type="text" class="form-control" id="number" name="number" placeholder="Ex: 123456"
                            value="<?php print(isset($data["number"]) ? $data["number"] : "") ?>">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="complement">Complemento:</label>
                        <input type="text" class="form-control" id="complement" name="complement" placeholder=""
                            value="<?php print(isset($data["complement"]) ? $data["complement"] : "") ?>">
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="district">Bairro:</label>
                        <input type="text" class="form-control" id="district" name="district" placeholder=""
                            value="<?php print(isset($data["district"]) ? $data["district"] : "") ?>">
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="city">Cidade:</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder=""
                            value="<?php print(isset($data["city"]) ? $data["city"] : "") ?>">
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="uf">UF</label>
                        <select class="form-control" id="uf" name="uf">
                            <option value="">Selecione</option>
                            <?php
                            foreach ($GLOBALS["ufbr_lists"] as $k => $v) {
                                printf('<option %s value="%s">%s</option>', isset($data["uf"]) && $k == $data["uf"] ? ' selected' : '', $k, $v);
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>