<?php 
class SellController extends BaseController {
    private $sellModel;

    public function index() {
        $this->view("/dashboard/sell");
    }
}
    