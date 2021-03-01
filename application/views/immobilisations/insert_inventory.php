<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Saisi d'inventaire</h2>
            <form action="<?php echo base_url("immo/insertInv") ?>" method="post">
                <div class="form-group">
                    <label for="">Immobilisations</label>
                    <select class="form-control form-control-sm" name="immo" id="">
                        <?php foreach ($immos as $immo) { ?>
                            <option value="<?php echo $immo->id; ?>"><?php echo $immo->designation; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Etat</label>
                    <select class="form-control form-control-sm" name="state" id="">
                        <option value="Inutilisable">Inutilisable</option>
                        <option value="Mauvais">Mauvais</option>
                        <option value="moyen">moyen</option>
                        <option value="bon">bon</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="desc" class="form-control form-control-sm" name="" id="" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Date d'inventaire</label>
                    <input name="date" class="form-control form-control-sm" type="date">
                </div>
                <input type="submit" class="btn btn-primary btn-block btn-sm" value="Valider">
            </form>
        </div>
    </div>
</div>