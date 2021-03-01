<?php
$currDt = new DateTime();
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Entrée de stock</h1>
            <form action="<?php echo base_url("/inv/in") ?>" method="post">
                <div class="form-group">
                    <label for="">Produit</label>
                    <select name="product" id="" class="form-control form-control-sm">
                        <?php foreach ($products as $product) { ?>
                            <option value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Date entrée</label>
                    <input name="date" class="form-control form-control-sm" type="date" value="<?php echo $currDt->format("Y-m-d"); ?>">
                </div>
                <div class="form-group">
                    <label for="">Prix Unitaire</label>
                    <input name="unit-price" class="form-control form-control-sm" type="number">
                </div>
                <div class="form-group">
                    <label for="">Quantité</label>
                    <input name="quantity" class="form-control form-control-sm" type="number">
                </div>
                <input type="submit" class="btn btn-primary btn-block" value="Valider">
            </form>
        </div>
    </div>
</div>