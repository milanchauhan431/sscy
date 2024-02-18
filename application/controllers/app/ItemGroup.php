<?php
class ItemGroup extends MY_Controller{
    private $index = "app/item_group/index";
    private $form = "app/item_group/form";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "itemGroup";
        $this->data['headData']->pageName = "Product Group";
    }

    public function index(){
        $this->load->view($this->index,$this->data);
    }

    public function getDTRows(){
        $data = $this->input->post();
        $result = $this->itemGroup->getDTRows($data);
        $this->printJson($result);
    }

    public function addItemGroup(){
        $this->load->view($this->form,$this->data);
    }

    public function save(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['group_name']))
            $errorMessage['group_name'] = "Group name is required.";

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $this->printJson($this->itemGroup->save($data));
        endif;
    }

    public function edit(){
        $data = $this->input->post();
        $this->data['dataRow'] = $this->itemGroup->getItemGroup($data);
        $this->load->view($this->form,$this->data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->itemGroup->delete($id));
        endif;
    }
}
?>