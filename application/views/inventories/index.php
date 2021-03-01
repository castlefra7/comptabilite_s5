<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Liste produits</h1>
            <div class="my-2">
                    <a class="btn btn-primary btn-sm" href="<?php echo base_url("inv/outPage"); ?>">Sortie de stock</a>

                    <a class="btn btn-primary btn-sm" href="<?php echo base_url("inv/inPage"); ?>">Entrée de stock</a>

                        <a class="btn btn-primary btn-sm"  href="<?php echo base_url("inv/inPage"); ?>">insertion de produit</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Désignation</th>
                        <th scope="col">Méthode de gestion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product) { ?>
                    <tr>
                        <td scope="row"><?php echo $product->code; ?></td>
                        <td scope="row"><?php echo $product->name; ?></td>
                        <td scope="row"><?php echo $product->inventory_method; ?></td>
                        <td scope="row">
                            <a href="<?php echo base_url("inv/infos/$product->id"); ?>" class="btn btn-primary btn-sm">Détails</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>