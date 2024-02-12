<?php
class ItemCategory extends MY_Controller{
    private $index = "app/item_category/index";
    private $form = "app/item_category/form";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "itemCategory";
        $this->data['headData']->pageName = "Item Category";
    }

    public function index(){
        $this->load->view($this->index,$this->data);
    }

    public function getDTRows(){
        $data = $this->input->post();
        $result = $this->itemCategory->getDTRows($data);
        $this->printJson($result);
    }

    public function addItemCategory(){
        $this->load->view($this->form,$this->data);
    }

    public function save(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['category_name']))
            $errorMessage['category_name'] = "Category name is required.";

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            $this->printJson($this->itemCategory->save($data));
        endif;
    }

    public function edit(){
        $data = $this->input->post();
        $this->data['dataRow'] = $this->itemCategory->getItemCategory($data);
        $this->load->view($this->form,$this->data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->itemCategory->delete($id));
        endif;
    }
}
?>