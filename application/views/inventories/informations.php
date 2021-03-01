<div class="container-fluid my-3">
    <div class="row mx-3">
        <div class="col-md-9">
            <h1>Stock produit</h1>
            <div class="row">
                <div class="col-md-4">
                    <form action="">
                        <div class="form-group">
                            <label for="">Produit</label>
                            <input type="text" class="form-control form-control-sm" value="<?php echo $product->name ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Méthode de valorisation stock</label>
                            <input readonly type="text" class="form-control form-control-sm" value="<?php echo $product->inventory_method; ?>">
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="card" style="width: 15rem;">
                            <div class="card-body">
                                <h5 class="card-title">Prix unitaire à ce jour</h5>
                                <p class="card-text">
                                    <?php echo $inv_info->unit_price; ?> Ar
                                </p>
                            </div>
                        </div>
                        <div class="card mx-1" style="width: 15rem;">
                            <div class="card-body">
                                <h5 class="card-title">Quantité</h5>
                                <p class="card-text">
                                    <?php echo $inv_info->quantity; ?> Ar
                                </p>
                            </div>
                        </div>
                        <div class="card" style="width: 15rem;">
                            <div class="card-body">
                                <h5 class="card-title">Valeur du stock</h5>
                                <p class="card-text">
                                    <?php echo $inv_info->amount; ?> Ar
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="my-5">
                <h2>Détails des opérations de stock</h2>
                <table class="mt-1 table table-sm table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Opération</th>
                            <th scope="col">Date</th>
                            <th scope="col">Prix Unitaire</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entries as $entry) { ?>
                            <tr>
                                <td><?php echo $entry->type; ?></td>
                                <td><?php echo $entry->date_inv; ?></td>
                                <td><?php echo $entry->unit_price; ?> Ar</td>
                                <td><?php echo $entry->quantity; ?></td>
                                <td><?php echo $entry->amount; ?> Ar</td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>