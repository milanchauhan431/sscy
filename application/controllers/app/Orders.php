<?php
class Orders extends MY_Controller{
    private $productList = "app/orders/product_list";
    private $index = "app/orders/index";
    private $accpetOrdFrom = "app/orders/accept_order_form";
    private $dispatchOrdFrom = "app/orders/dispatch_order_form";

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

    public function list(){
        $this->data['headData']->controller = "myOrders";
        $this->data['headData']->pageName = "My Orders";
        $this->load->view($this->index,$this->data);
    }

    public function getMyOrdersDTRows(){
        $data = $this->input->post();
        $result = $this->order->getDTRows($data);
        $this->printJson($result);
    }

    public function changeOrderStatus(){
        $data = $this->input->post();
        if(empty($data['id'])):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            if($data['trans_status'] == 1 && empty($data['delivery_date'])):
                $this->printJson(['status'=>0,'message'=>['delivery_date'=>'Est. Delivery Date is required.']]);
            endif;

            if($data['trans_status'] == 2 && empty($data['dispatch_qty'])):
                $this->printJson(['status'=>0,'message'=>['dispatch_qty'=>'Dispatch Qty. is required.']]);
            endif;

            $this->printJson($this->order->changeOrderStatus($data));
        endif;
    }

    public function acceptOrder(){
        $data = $this->input->post();
        $this->data['postData'] = (object) $data;
        $this->load->view($this->accpetOrdFrom,$this->data);
    }

    public function dispatchOrder(){
        $data = $this->input->post();
        $this->data['dataRow'] = $this->order->getOrder($data);
        $this->load->view($this->dispatchOrdFrom,$this->data);
    }
}
?>