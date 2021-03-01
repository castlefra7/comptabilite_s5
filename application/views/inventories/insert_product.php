<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Saisi de produit</h2>
            <form action="<?php echo base_url("inv/insertProduct"); ?>" method="post">
                <div class="form-group">
                    <label for="">Code</label>
                    <input name="code" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Nom</label>
                    <input name="name" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Méthode de gestion</label>
                    <select name="method" class="form-control form-control-sm">
                        <option value="CMUP">CMUP</option>
                        <option value="FIFO">FIFO</option>
                        <option value="LIFO">LIFO</option>
                    </select>
                </div>
                <input type="submit" class="btn  btn-primary btn-block btn-sm" value="Enregistrer">
            </form>
        </div>
    </div>
</div>