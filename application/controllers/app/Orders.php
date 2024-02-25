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

    public function getItemDetail(){
        $data = $this->input->post();
        $data['categoryList'] = 1;
        $this->data['dataRow'] = $this->item->getItem($data);
        $this->load->view("app/orders/item_detail",$this->data);
    }

    public function formatCartItemData(){
        $data = $this->input->post();

        $dataRow = [];
        foreach($data['category_id'] as $key=>$category_id):
            if($data['category_qty'][$key] > 0):
                $dataRow[$data['item_id'].$data['group_id'].$category_id] = [
                    'id' => '',
                    'party_id' => $data['party_id'],
                    'item_id' => $data['item_id'],
                    'item_code' => $data['item_code'],
                    'item_name' => $data['item_name'],
                    'item_image' => $data['item_image'],
                    'group_id' => $data['group_id'],
                    'group_name' => $data['group_name'],
                    'category_id' => $category_id,
                    'category_name' => $data['category_name'][$key],
                    'qty' => $data['category_qty'][$key],
                    'price' => $data['price'],
                    'amount' => round(($data['category_qty'][$key] * $data['price']),2)
                ];
            endif;
        endforeach;

        $this->printJson($dataRow);
    }

    public function saveOrder(){
        $data = $this->input->post();

        if(empty($data)):
            $this->printJson(['status'=>0,'message'=>'Please add item to place order.']);
        else:
            $this->printJson($this->order->saveOrder($data));
        endif;
    }
}
?>