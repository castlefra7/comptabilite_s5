<?php
$lengthDeg = count($amortissementsDeg);
$lengthLin = count($amortLin);
$period = 1;
if (isset($_GET["period"])) {
    $period = $_GET["period"];
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h1>Immobilisation</h1>

            <form>
                <div class="form-group">
                    <label for="">Désignation:</label>
                    <input readonly value="<?php echo $immo->getDesignation(); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Date achat:</label>
                    <input readonly value="<?php echo $immo->getBuy_date(); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Date de mise en service:</label>
                    <input readonly value="<?php echo $immo->getUsage_date(); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Fournisseur:</label>
                    <input readonly value="<?php echo $immo->getSupplier_id(); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Prix d'achat:</label>
                    <input readonly value="<?php echo number_format($immo->getBuy_price(), 2, ",", " "); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Nombre années d'amortissement:</label>
                    <input readonly value="<?php echo $immo->getAmortissed_year(); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Type d'amortissement:</label>
                    <input readonly value="<?php echo $immo->amortissed_type == 1 ? "Linéaire" : "Dégressif"; ?>" type="text" class="form-control form-control-sm">
                </div>
            </form>


        </div>
        <div class="col-md-8 mt-5">

            <h2>Informations supplémentaires</h2>
            <form>
                <div class="form-group row">
                    <label for="" class="col-md-4">Utilisateur en cours:</label>
                    <div class="col-sm-8">
                        <input readonly type="text" class="form-control form-control-sm" value="<?php if ($lastAssign != null) {
                                                                                                    echo $lastAssign;
                                                                                                } ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Dernier entretien:</label>
                    <div class="col-sm-8">
                        <input readonly type="text" class="form-control form-control-sm" value="<?php if ($lastMaint != null) {
                                                                                                    echo $lastMaint;
                                                                                                } ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-4">Dernier inventaire:</label>
                    <div class="col-sm-8">
                        <input readonly type="text" value="<?php
                                                            if ($lastInv != null) {
                                                                echo $lastInv;
                                                            }

                                                            ?>" class="form-control form-control-sm">
                    </div>
                </div>
            </form>

            <a href="/immo/histories/<?php echo $immo->code; ?>" class="btn btn-primary btn-sm">Historiques</a>

            <a href="/immo/histories/<?php echo $immo->code; ?>" class="btn btn-primary btn-sm">Energies</a>
            <div class="mt-5">
                <h2>Valeur immobilisation</h2>

                <form action="/immo/detailsInfo/<?php echo $immo->code; // TODO CURRENT DATE ?>" style="width: 12rem;">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input name="date" type="date" value="2021-03-01" class="form-control form-control-sm">
                    </div>
                    <input type="submit" class="btn btn-block btn-sm btn-primary" value="Valider">
                </form>

                <div class="form-group">
                    <label for="">Montant:</label>
                    <input readonly type="text" class="form-control form-control-sm" value="<?php echo $currentAmount; ?>">
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="/immo/detailsInfo/<?php echo $immo->code; ?>" method="get" class="my-2">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="period" id="period1" value="1" <?php echo $period == 1 ? "checked" : "" ?>>
                    <label class="form-check-label" for="period1">
                        Annuel
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="period" id="period2" value="2" <?php echo $period == 2 ? "checked" : "" ?>>
                    <label class="form-check-label" for="period2">
                        Mensuel
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="period" id="period3" value="3" <?php echo $period == 3 ? "checked" : "" ?>>
                    <label class="form-check-label" for="period3">
                        Journalier
                    </label>
                </div>
                <input type="submit" class="btn btn-primary btn-sm" value="Valider">
            </form>
        </div>
        <?php if ($immo->amortissed_type == 1) { ?>
            <div class="col-md-12">
                <h2>Tableau d'amortissements linéaire</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Cumul début</th>
                            <th scope="col">Dotation</th>
                            <th scope="col">Cumul fin</th>
                            <th scope="col">taux</th>
                            <th scope="col">Valeur nette</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($iA = 0; $iA < $lengthLin; $iA++) { ?>
                            <tr>
                                <td><?php echo $amortLin[$iA]->getCumulDebut(); ?></td>
                                <td><?php echo $amortLin[$iA]->getDotation(); ?></td>
                                <td><?php echo $amortLin[$iA]->getCumulFin(); ?></td>
                                <td><?php echo $amortLin[$iA]->getTaux(); ?></td>
                                <td><?php echo ($amortLin[$iA]->getValeurNette()); ?></td>
                                <td><?php echo $amortLin[$iA]->begin_date->format("d/m/Y"); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
        <?php if ($immo->amortissed_type == 2) { ?>
            <div class="col-md-12">
                <h2>Tableau d'amortissements degressif</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Valeur initiale</th>
                            <th scope="col">Cumul début</th>
                            <th scope="col">Dotation</th>
                            <th scope="col">Cumul fin</th>
                            <th scope="col">taux dégressif</th>
                            <th scope="col">taux linéaire</th>
                            <th scope="col">Valeur nette</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($iA = 0; $iA < $lengthDeg; $iA++) { ?>
                            <tr>
                                <td><?php echo $amortissementsDeg[$iA]->getInitialValue(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getCumulDebut(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getDotation(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getCumulFin(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getTauxDegressif(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getTauxLineaire(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getValeurNette(); ?></td>
                                <td><?php echo $amortissementsDeg[$iA]->getBegin_date()->format("d/m/y"); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>
</div>