<div class="wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3">
                <img src="<?php echo plugin_dir_url( dirname( __DIR__ ) ); ?>/admin/assets/img/logo-oliemonster.jpg"
                alt="" class="img-fluid d-block mx-auto" width="140" height="79">
            </div> <!-- .col-md-2 -->
            <div class="col-md-10 col-lg-7">
                <h1 class="h1 mb-4">Aanvragen controle</h1>
                <p class="mb-4">
                Op deze pagina kunt u een controle aanvragen voor uw oliemonster.
                </p> <!-- .mb-4 -->
                <form action="">
                    <div class="form-group row mb-3">
                        <label for="monsternummer" class="col-sm-3 col-form-label">Monsternummer</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="monsternummer" type="number" readonly class="form-control-plain-text w-100" id="monsternummer" aria-describedby="monsternummer-help" value="1203232">
                            <small id="monsternummer-help" class="form-text text-muted d-block">U kunt dit nummer niet wijzigen. Dit wordt automatisch toegekend.</small>
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="klantnaam" class="col-sm-3 col-form-label">Klant</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="klantnaam" type="text" class="form-control-plain-text w-100" id="klantnaam" placeholder="Vul hier uw naam in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="Schipnaam" class="col-sm-3 col-form-label">Schip</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="Schipnaam" type="text" class="form-control-plain-text w-100" id="Schipnaam" placeholder="Vul hier de naam van uw schip in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="motor" class="col-sm-3 col-form-label">Motor</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="motor" type="text" class="form-control-plain-text w-100" id="motor" placeholder="Vul hier uw motor in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="type" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="type-motor" type="text" class="form-control-plain-text w-100" id="type" placeholder="Vul hier het type in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="serienummer" class="col-sm-3 col-form-label">Serienummer</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="serienummer" type="text" class="form-control-plain-text w-100" id="serienummer" placeholder="Vul hier het serienummer in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="soort-onderzoek" class="col-sm-3 col-form-label">Soort onderzoek</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="soort-onderzoek" type="text" class="form-control-plain-text w-100" id="soort-onderzoek" placeholder="Vul hier het soort onderzoek in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="monster-datum" class="col-sm-3 col-form-label">Monster datum</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="monster-datum" type="text" class="form-control-plain-text w-100" id="monster-datum" placeholder="Vul hier de monster datum in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="urenstand-motor" class="col-sm-3 col-form-label">Urenstand motor</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="urenstand-motor" type="number" class="form-control-plain-text w-100" id="urenstand-motor" placeholder="Vul hier de urenstand in van de motor">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="merk-olie" class="col-sm-3 col-form-label">Merk olie</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="merk-olie" type="text" class="form-control-plain-text w-100" id="merk-olie" placeholder="Vul hier het merk in van de olie">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="type-olie" class="col-sm-3 col-form-label">Type olie</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="type-olie" type="text" class="form-control-plain-text w-100" id="type-olie" placeholder="Vul hier het type in van de olie">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="urengebruik-olie" class="col-sm-3 col-form-label">Urengebruik olie</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="urengebruik-olie" type="number" class="form-control-plain-text w-100" id="urengebruik-olie" placeholder="Vul hier het urengebruik in van de olie">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="olie-ververst" class="col-sm-3 col-form-label">Olie ververst</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <select name="olie-ververst" id="olie-ververst" class="custom-select w-100">
                                <option value="">Selecteer ja of nee</option>
                                <option value="1">Ja</option>
                                <option value="2">Nee</option>
                            </select>
                        </div> <!-- .col-sm-9 -->
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="filters-ververst" class="col-sm-3 col-form-label">Filters ververst</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <select name="filters-ververst" id="filters-ververst" class="custom-select w-100">
                                <option value="">Selecteer ja of nee</option>
                                <option value="1">Ja</option>
                                <option value="2">Nee</option>
                            </select>
                        </div> <!-- .col-sm-9 -->
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="koelmiddel-gebruikt" class="col-sm-3 col-form-label">Koelmiddel gebruikt</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <select name="koelmiddel-gebruikt" id="koelmiddel-gebruikt" class="custom-select w-100">
                                <option value="">Selecteer ja of nee</option>
                                <option value="1">Ja</option>
                                <option value="2">Nee</option>
                            </select>
                        </div> <!-- .col-sm-9 -->
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="merk-koelmiddel" class="col-sm-3 col-form-label">Merk koelmiddel</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <input name="merk-koelmiddel" type="text" class="form-control-plain-text w-100" id="merk-koelmiddel" placeholder="Vul hier het merk van uw koelmiddel in">
                        </div>
                    </div> <!-- .form-group -->
                    <div class="form-group row mb-3">
                        <label for="opmerkingen" class="col-sm-3 col-form-label">Opmerkingen</label>
                        <div class="col-sm-9 col-lg-9 col-xl-6">
                            <textarea name="opmerking" class="form-control w-100" id="opmerkingen" rows="10" placeholder="U kunt hier eventuele opmerkingen kwijt"></textarea>
                        </div>
                    </div> <!-- .form-group -->
                    <button type="submit" class="btn mb-3 w-100 form-submit-button">Indienen aanvraag controle</button>
                </form>
            </div> <!-- .col-md-10 -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</div> <!-- .wrap -->