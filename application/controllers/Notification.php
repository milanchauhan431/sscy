<?php
class Notification extends MY_Controller{   

    public function index(){
        $this->load->view('notification');
    }

    public function send(){

        $data['notificationMsg'] = "Notification test successfull.";
        $data['notificationTitle'] = "Test Notification";
        $data['callBack'] = base_url('notification');
        $data['emp_ids'] = [1];

        $result = $this->masterModel->notify($data);
        $this->printJson($result);
    }
}
?>