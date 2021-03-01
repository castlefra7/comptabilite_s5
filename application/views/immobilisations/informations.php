<?php
$lengthDeg = count($amortissementsDeg);
$lengthLin = count($amortLin);
$period = 1;
$currentDate = new DateTime();
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
                    <input readonly value="<?php echo $immo->supplier_name; ?>" type="text" class="form-control form-control-sm">
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

            <a href="<?php echo base_url("/immo/histories/$immo->code"); ?>" class="btn btn-primary btn-sm">Historiques</a>

            <a href="<?php echo base_url("/immo/histories/$immo->code"); ?>" class="btn btn-primary btn-sm">Energies</a>
            <div class="mt-5">
                <h2>Valeur immobilisation</h2>

                <form action="<?php echo base_url("/immo/detailsInfo/$immo->code");?>" style="width: 12rem;">
                    <div class="form-group">
                        <label for="">Date:</label>
                        <input name="date" type="date" value="<?php echo $currentDate->format("Y-m-d"); ?>" class="form-control form-control-sm">
                    </div>
                    <input type="submit" class="btn btn-block btn-sm btn-primary" value="Valider">
                </form>

                <div class="form-group">
                    <label for="">Montant:</label>
                    <input readonly type="text" class="form-control input-lg" value="<?php echo format_number($currentAmount); ?>">
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url("/immo/detailsInfo/$immo->code"); ?>" method="get" class="my-2">
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
                <h2>Tableau d'amortissements linéaire (Ar)</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-right">Cumul début</th>
                            <th scope="col" class="text-right">Dotation</th>
                            <th scope="col" class="text-right">Cumul fin</th>
                            <th scope="col" class="text-right">taux</th>
                            <th scope="col" class="text-right">Valeur nette</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($iA = 0; $iA < $lengthLin; $iA++) { ?>
                            <tr>
                                <td class="text-right"><?php echo format_number($amortLin[$iA]->getCumulDebut()); ?></td>
                                <td class="text-right"><?php echo format_number($amortLin[$iA]->getDotation()); ?></td>
                                <td class="text-right"><?php echo format_number($amortLin[$iA]->getCumulFin()); ?></td>
                                <td class="text-right"><?php echo percent($amortLin[$iA]->getTaux()); ?></td>
                                <td class="text-right"><?php echo format_number($amortLin[$iA]->getValeurNette()); ?></td>
                                <td class="text-right"><?php echo $amortLin[$iA]->begin_date->format("d/m/Y"); ?></td>
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
                            <th scope="col" class="text-right">Valeur initiale</th>
                            <th scope="col" class="text-right">Cumul début</th>
                            <th scope="col" class="text-right">Dotation</th>
                            <th scope="col" class="text-right">Cumul fin</th>
                            <th scope="col" class="text-right">taux dégressif</th>
                            <th scope="col" class="text-right">taux linéaire</th>
                            <th scope="col" class="text-right">Valeur nette</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($iA = 0; $iA < $lengthDeg; $iA++) { ?>
                            <tr>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getInitialValue()); ?></td>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getCumulDebut()); ?></td>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getDotation()); ?></td>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getCumulFin()); ?></td>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getTauxDegressif()); ?></td>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getTauxLineaire()); ?></td>
                                <td class="text-right"><?php echo format_number($amortissementsDeg[$iA]->getValeurNette()); ?></td>
                                <td class="text-right"><?php echo $amortissementsDeg[$iA]->getBegin_date()->format("d/m/y"); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>
</div>