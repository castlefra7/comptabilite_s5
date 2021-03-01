<?php

class Home extends Base_Controller {
    public function index() {
        $data = array();
        $data["content"] = "home";
        $this->load->view("template/content", $data);
    }
}