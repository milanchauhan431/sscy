<?php
class Orders extends MY_Controller{
    private $productList = "app/orders/product_list";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "orders";
        $this->data['headData']->pageName = "Products";
    }

    public function index(){
        $this->data['userList'] = $this->userMaster->getUserList();
        $this->data['itemGroupList'] = $this->itemGroup->getItemGroupList();
        //$this->data['itemCategoryList'] = $this->itemCategory->getItemCategoryList();
        $this->load->view($this->productList,$this->data);
    }

    public function getProductListDTRows(){
        $data = $this->input->post();
        $result = $this->item->getDTRows($data);
        $this->printJson($result);
    }
}
?>