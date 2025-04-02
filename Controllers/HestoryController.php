<?php
require_once "Models/HistoryModel.php";
require_once "BaseController.php";

class HistoryController extends BaseController
{
    private $historyModel;

    public function __construct()
    {
        $this->historyModel = new HistoryModel();
    }




}
