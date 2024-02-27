<?php
class Report extends MY_Controller{
    private $ledger = "app/report/ledger";
    private $ledgerDetail = "app/report/ledger_detail";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "report";
        $this->data['headData']->pageName = "";
    }

    public function ledgers(){
        $this->data['headData']->pageName = "Kariger Ledger";
        $this->load->view($this->ledger,$this->data);
    }

    public function getLedgerList(){
        $data = $this->input->post();
        $result = $this->report->getLedgerList($data);
        $this->printJson($result);
    }

    public function ledgerDetail($id){
        $userData = $this->userMaster->getUser(['id'=>$id]);
        $this->data['headData']->pageName = $userData->user_name;
        $this->data['userData'] = $userData;
        $this->load->view($this->ledgerDetail,$this->data);
    }

    public function getLedgerDetail($id){
        $data = $this->input->post();
        $data['party_id'] = $id;
        $result = $this->report->getLedgerTrans($data);
        $result["ledgerData"] = $this->report->getLedgerBalance($data);
        $this->printJson($result);
    }
}
?>