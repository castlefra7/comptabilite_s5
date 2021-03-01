<?php

class Immo extends Base_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model("immobilisations/immo_model");
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
        if($date == null) $date = "2021-03-01"; // TODO GET CURRENT DATE

        $data["currentAmount"] = $this->immo_model->getCurrentAmount($code, $date);

        $this->load->view($this->template, $data);
    }

    public function insert() {
        var_dump($this->input->post("years"));
        $new_immo = $this->immo_model->instantiate($this->input->post("code"), $this->input->post("design"), $this->input->post("buy-date"), $this->input->post("usage-date"), $this->input->post("price"), $this->input->post("years"), $this->input->post("type"), $this->input->post("suppl"), $this->input->post("coeff"));
        $new_immo->insert();

        redirect("/immo/index");
    }

    public function insertPage() {
        $data = array();
        $data["content"] = "immobilisations/insert";
        $data["suppliers"] = $this->supplier_model->getAllSuppliers();
        $this->load->view($this->template, $data);
    }
}