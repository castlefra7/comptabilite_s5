<div class="container">

    <div class="row mx-1">

        <div class="col-md-4 ">
            <h2>Immobilisation</h2>
            <form>
                <div class="form-group">
                    <label for="">Code</label>
                    <input readonly value="<?php echo $immo->code; ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Désignation</label>
                    <input readonly value="<?php echo $immo->getDesignation(); ?>" type="text" class="form-control form-control-sm">
                </div>
                <div class="form-group">
                    <label for="">Date de mise en service</label>
                    <input readonly value="<?php echo $immo->getUsage_date(); ?>" type="text" class="form-control form-control-sm">
                </div>
            </form>
        </div>
    </div>

    <div class="row mx-1">
        <div class="col-md-6">
            <h3>Historique inventaires</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Etat</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr></tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <div class="mb-5">
                <h3>Historique affectations</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Etat</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Historique entretiens</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Etat</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>