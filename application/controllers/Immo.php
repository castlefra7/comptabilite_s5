<?php

class Immo extends Base_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model("immobilisations/immo_model");
        $this->load->model("immobilisations/service_model");
        $this->load->model("immobilisations/maintenance_model");
        $this->load->model("immobilisations/assign_model");
        $this->load->model("supplier_model");
        
    }
    public function index() {

        $data = array();
        $data["content"] = "immobilisations/index";
        $data["immobilisations"] =  $this->immo_model->getAllImo();
        $this->load->view($this->template, $data);

    }

    public function histories($code) {
        $data = array();
        $data["content"] = "immobilisations/histories";
        $data["immo"] =  $this->immo_model->getImmo($code);
        $data["invHist"] = $this->immo_model->getInventoryHistory($code);
        $data["maintHist"] = $this->immo_model->geMaintHistory($code);
        $data["assignHist"] = $this->immo_model->getAssignHistory($code);

        $this->load->view($this->template, $data);
    }

    public function detailsInfo($code) {
        $data = array();
        $data["content"] = "immobilisations/informations";
        $data["immo"] =  $this->immo_model->getImmo($code);
        $data["lastInv"] = $this->immo_model->getLastInv($code);
        $data["lastAssign"] = $this->immo_model->getLastAssign($code);
        $data["lastMaint"] = $this->immo_model->getLastMaintenance($code);
        $period = $this->input->get("period");
        if($period == null) $period = 1;
        // TODO check if amortissed_type is whether linear or degressif
        $data["amortissementsDeg"] = $this->immo_model->getAmortissementsDegressif($code, $period);
        $data["amortLin"] = $this->immo_model->getAmortissementsLineaire($code, $period);
        $date = $this->input->get("date");
        $currentDate = new DateTime();

        if($date == null) $date = $currentDate->format("Y-m-d"); // TODO GET CURRENT DATE

        $data["currentAmount"] = $this->immo_model->getCurrentAmount($code, $date);

        $this->load->view($this->template, $data);
    }

    public function insert() {
        $new_immo = $this->immo_model->instantiate($this->input->post("code"), $this->input->post("design"), $this->input->post("buy-date"), $this->input->post("usage-date"), $this->input->post("price"), $this->input->post("years"), $this->input->post("type"), $this->input->post("suppl"), $this->input->post("coeff"));
        $new_immo->insert();
        // var_dump($new_immo);
    

        redirect("/immo/index");
    }

    public function insertPage() {
        $data = array();
        $data["content"] = "immobilisations/insert";
        $data["suppliers"] = $this->supplier_model->getAllSuppliers();
        $this->load->view($this->template, $data);
    }

    public function insetMaintPage() {
        $data = array();
        $data["content"] = "immobilisations/insert_maintenance";
        $data["immos"] = $this->immo_model->getAllImo();
        $this->load->view($this->template, $data);
    }

    public function insertMaint() {
        $new_maint = $this->maintenance_model->instantiate($this->input->post("immo"), $this->input->post("repairer"), $this->input->post("date"),$this->input->post("desc"));
        $new_maint->insert();
        redirect("/immo/index");
    }

    public function insertInvPage() {
        $data = array();
        $data["content"] = "immobilisations/insert_inventory";
        $data["immos"] = $this->immo_model->getAllImo();
        $this->load->view($this->template, $data);
    }

    public function insertInv() {
        $new_maint = $this->inv_model->instantiate($this->input->post("immo"), $this->input->post("date"), $this->input->post("state"),$this->input->post("desc"));
        $new_maint->insert();
        redirect("/immo/index");
    }



    public function insertAssignPage() {
        $data = array();
        $data["content"] = "immobilisations/insert_assign";
        $data["immos"] = $this->immo_model->getAllImo();
        $data["services"] = $this->service_model->findAllServices();
        $this->load->view($this->template, $data);
    }

    public function insertAssign() {
        $new_maint = $this->assign_model->instantiate($this->input->post("immo"), $this->input->post("date"), $this->input->post("service"),$this->input->post("desc"));
        $new_maint->insert();
        redirect("/immo/index");
    }
}