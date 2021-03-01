<?php

class Inv extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("inventories/product_model");
        $this->load->model("inventories/Inventory_model", "invv_model");
        $this->load->model("inventories/InventoryInfo_model", "inv_info");
    }

    public function index() {
        $data = array();
        $data["content"] = "inventories/index";
        $data["products"] = $this->product_model->getAllProducts();
        $this->load->view($this->template, $data);
    }

    public function infos($proudct_id)
    {

        $data = array();
        $data["content"] = "inventories/informations";
        $data["product"] = $this->product_model->getProduct($proudct_id);
        $data["entries"] = $this->invv_model->getAllEntries($proudct_id);
        $data["inv_info"] = $this->product_model->getInfo($proudct_id);

        $this->load->view($this->template, $data);
    }

    public function out() {
        $data = array();
        $this->product_model->insertOut($this->input->post("product"), $this->input->post("date"), $this->input->post("quantity"));
        // redirect("/inv/index");
    }

    public function in() {
        $this->product_model->insertIn($this->input->post("product"), $this->input->post("date"), $this->input->post("quantity"), $this->input->post("unit-price"));
        redirect("/inv/index");
    }

    public function outPage()
    {
        $data = array();
        $data["content"] = "inventories/inventory_out";
        $data["products"] = $this->product_model->getAllProducts();

        $this->load->view($this->template, $data);
    }

    public function inPage()
    {
        $data = array();
        $data["content"] = "inventories/inventory_in";
        $data["products"] = $this->product_model->getAllProducts();

        $this->load->view($this->template, $data);
    }
}
