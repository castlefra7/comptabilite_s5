<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Insertion d'immobilisation</h1>
            <form action="<?php echo base_url('immo/insert'); ?>" method="post">
                <div class="form-group">
                    <label for="">Code</label>
                    <input value="c004" name="code" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Désignation</label>
                    <input value="test" name="design" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Prix d'achat</label>
                    <input value="25000" name="price" type="number" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Date achat</label>
                    <input value="2021-01-01" name="buy-date" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Date d'utilisation</label>
                    <input value="2021-01-15" name="usage-date" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Nombre d'années d'amortissement</label>
                    <input value="5" name="years" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Fournisseurs</label>
                    <select name="suppl" class="form-control form-control-sm">
                        <?php foreach ($suppliers as $supp) { ?>
                            <option default value="<?php echo $supp->id; ?>"><?php echo $supp->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Type d'amortissement</label>
                    <select name="type" class="form-control form-control-sm">
                        <option default value="1">Linéaire</option>
                        <option value="2">Dégressif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Coefficient</label>
                    <input value="0" name="coeff" type="text" class="form-control form-control-sm">
                </div>
                <input type="submit" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>
</div>