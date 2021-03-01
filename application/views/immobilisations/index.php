<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Liste des immobilisations</h1>
            <div>
            <a class="btn btn-primary btn-sm" href="<?php echo base_url("immo/insertPage"); ?>">Saisi immobilisation</a>
            <a class="btn btn-primary btn-sm" href="<?php echo base_url("immo/insetMaintPage"); ?>">Saisi maintenance</a>
            <a class="btn btn-primary btn-sm" href="<?php echo base_url("immo/insertInvPage"); ?>">Saisi inventaire</a>

            </div>

            <table class="table mt-2">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Désignation</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($immobilisations as $immo) { ?>
                        <tr>
                            <td><?php echo $immo->getCode(); ?></td>
                            <td><?php echo $immo->getDesignation() ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="<?php echo base_url("immo/detailsInfo/" . $immo->getCode()); ?>">Détails</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>