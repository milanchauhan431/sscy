<?php
class PaymentVoucher extends MY_Controller{
    private $index = "app/payment_voucher/index";
    private $form = "app/payment_voucher/form";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "paymentVoucher";
        $this->data['headData']->pageName = "Payment Voucher";
    }

    public function index(){
        $this->load->view($this->index,$this->data);
    }

    public function getDTRows(){
        $data = $this->input->post();
        $result = $this->paymentVoucher->getDTRows($data);
        $this->printJson($result);
    }

    public function addPaymentVoucher(){
        $this->load->view($this->form,$this->data);
    }

    public function save(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['trans_date']))
            $errorMessage['trans_date'] = "Vou. Date is required.";
        if(empty($data['amount']))
            $errorMessage['amount'] = "Vou. amount is required.";

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $this->printJson($this->paymentVoucher->save($data));
        endif;
    }

    public function edit(){
        $data = $this->input->post();
        $this->data['dataRow'] = $this->paymentVoucher->getPaymentVoucher($data);
        $this->load->view($this->form,$this->data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->paymentVoucher->delete($id));
        endif;
    }
}
?>