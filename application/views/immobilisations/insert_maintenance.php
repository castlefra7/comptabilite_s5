<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Saisi de maintenance</h2>
            <form action="<?php echo base_url("immo/insertMaint") ?>" method="post">
                <div class="form-group">
                    <label for="">Immobilisations</label>
                    <select class="form-control form-control-sm" name="immo" id="">
                        <?php foreach($immos as $immo) { ?>
                            <option value="<?php echo $immo->id; ?>"><?php echo $immo->designation; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Réparateur</label>
                    <textarea name="repairer" class="form-control form-control-sm" name="" id="" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="desc" class="form-control form-control-sm" name="" id="" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Date de maintenance</label>
                    <input name="date" class="form-control form-control-sm" type="date">
                </div>
                <input type="submit" class="btn btn-primary btn-block btn-sm" value="Valider">
            </form>
        </div>
    </div>
</div>