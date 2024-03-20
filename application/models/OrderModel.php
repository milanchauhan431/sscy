<?php
class OrderModel extends masterModel{
    private $orderTrans = "order_transaction";

    public function getDTRows($data){
        $data['tableName'] = $this->orderTrans;
        $data['select'] = "order_transaction.*,item_master.item_code,item_master.item_name,IF(item_master.item_image != '',CONCAT('".base_url('assets/uploads/products/')."',item_master.item_image),'".base_url("assets/dist/img/app-img/sample/brand/1.jpg")."') as item_image,item_group.group_name,category_master.category_name,(CASE WHEN order_transaction.trans_status = 0 THEN 'Pending' WHEN order_transaction.trans_status = 1 THEN 'Accepted' WHEN order_transaction.trans_status = 2 THEN 'Competed' WHEN order_transaction.trans_status = 3 THEN 'Cancled' WHEN order_transaction.trans_status = 4 THEN 'Rejected' ELSE '' END) as order_status,DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y') as trans_date,ifnull(order_transaction.remark,'') as remark";

        $data['leftJoin']['item_master'] = "item_master.id = order_transaction.item_id";
        $data['leftJoin']['item_group'] = "item_group.id = order_transaction.group_id";
        $data['leftJoin']['category_master'] = "category_master.id = order_transaction.category_id";

        if($this->userRole > 1):
            $data['where']['order_transaction.party_id'] = $this->loginId;
            $data['where']['order_transaction.trans_status !='] = 3;
        endif;

        $data['where']['order_transaction.entry_type'] = 5;

        /* if(!empty($data['filters'])):
            if(!empty($data['filters']['item_code'])):
                $data['where']['item_master.item_code'] = $data['filters']['item_code'];
            endif;

            if(!empty($data['filters']['group_id'])):
                $data['where']['item_master.group_id'] = $data['filters']['group_id'];
            endif;
        endif; */

        $data['searchCol'][] = "order_transaction.trans_number";
        $data['searchCol'][] = "DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y')";
        $data['searchCol'][] = "order_transaction.qty";
        $data['searchCol'][] = "order_transaction.amount";
        $data['searchCol'][] = "(CASE WHEN order_transaction.trans_status = 0 THEN 'Pending' WHEN order_transaction.trans_status = 1 THEN 'Accepted' WHEN order_transaction.trans_status = 2 THEN 'Competed' WHEN order_transaction.trans_status = 3 THEN 'Cancled' WHEN order_transaction.trans_status = 4 THEN 'Rejected' ELSE '' END)";
        $data['searchCol'][] = "item_master.item_code";
        $data['searchCol'][] = "item_master.item_name";
        $data['searchCol'][] = "item_group.group_name";
        $data['searchCol'][] = "category_master.category_name";

        $data['order_by']['order_transaction.trans_no'] = "DESC";

		return $this->pagingRows($data);
    }

    public function getNextNo($entry_type){
        $queryData = array();
        $queryData['tableName'] = $this->orderTrans;
        $queryData['select'] = "ifnull((MAX(trans_no) + 1),1) as trans_no";
        $queryData['where']['entry_type'] = $entry_type;
        $result = $this->row($queryData);
        return $result->trans_no;
    }

    public function saveOrder($data){
        try{
            $this->db->trans_begin();

            foreach($data['order_item'] as $row):
                $row['id'] = "";
                $row['entry_type'] = 5;
                $row['trans_prefix'] = "#";
                $row['trans_no'] = $this->getNextNo($row['entry_type']);
                $row['trans_number'] = $row['trans_prefix'].$row['trans_no'];
                $row['trans_date'] = date("Y-m-d");
                $row['vou_acc_id'] = $this->loginId;
                $row['opp_acc_id'] = $row['party_id'];
                $row['amount'] = round(($row['qty'] * $row['price']),2);
                $row['p_or_m'] = 1;
                $row['c_or_d'] = 'Cr';

                $result = $this->store($this->orderTrans,$row);
            endforeach;

            $result['message'] = "Order placed successfully.";

            /* Send Notification */
            $notifyData = array();
            $notifyData['notificationTitle'] = "New Order";
            $notifyData['notificationMsg'] = "You have new order. Please take action against order.";
            $notifyData['callBack'] = base_url("app/myOrders");
            $notifyData['user_ids'] = array_unique(array_column($data['order_item'],'party_id'));
            $this->notify($notifyData);

            if ($this->db->trans_status() !== FALSE):
                $this->db->trans_commit();
                return $result;
            endif;
        }catch(\Throwable $e){
            $this->db->trans_rollback();
            return ['status'=>2,'message'=>"somthing is wrong. Error : ".$e->getMessage()];
        }
    }

    public function getOrder($data){
        $queryData['tableName'] = $this->orderTrans;
        $queryData['select'] = "order_transaction.*";
        $queryData['where']['id'] = $data['id'];
        $result = $this->row($queryData);
        return $result;
    }

    public function getOrderList($data){
        $queryData = array();
        $queryData['tableName'] = $this->orderTrans;

        $queryData['select'] = "order_transaction.*,item_master.item_code,item_master.item_name,IF(item_master.item_image != '',CONCAT('".base_url('assets/uploads/products/')."',item_master.item_image),'".base_url("assets/dist/img/app-img/sample/brand/1.jpg")."') as item_image,item_group.group_name,category_master.category_name,(CASE WHEN order_transaction.trans_status = 0 THEN 'Pending' WHEN order_transaction.trans_status = 1 THEN 'Accepted' WHEN order_transaction.trans_status = 2 THEN 'Competed' WHEN order_transaction.trans_status = 3 THEN 'Cancled' WHEN order_transaction.trans_status = 4 THEN 'Rejected' ELSE '' END) as order_status,DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y') as trans_date,ifnull(order_transaction.remark,'') as remark";

        $queryData['leftJoin']['item_master'] = "item_master.id = order_transaction.item_id";
        $queryData['leftJoin']['item_group'] = "item_group.id = order_transaction.group_id";
        $queryData['leftJoin']['category_master'] = "category_master.id = order_transaction.category_id";

        $queryData['where']['order_transaction.party_id'] = $data['party_id'];
        $queryData['where']['order_transaction.trans_date'] = $data['trans_date'];
        if($data['trans_status'] != "")
            $queryData['where']['order_transaction.trans_status'] = $data['trans_status'];

        $queryData['order_by']['order_transaction.trans_date'] = "ASC";
        $queryData['order_by']['order_transaction.trans_no'] = "ASC";

        $result = $this->rows($queryData);
        return $result;
    }

    public function changeOrderStatus($data){
        try{
            $this->db->trans_begin();

            $orderData = $this->getOrder($data);

            if($data['trans_status'] == 1 && $orderData->trans_status == 3):
                return ['status'=>0,'message'=>'Order has been canceled. you can not accept it.'];
            endif;

            if($data['trans_status'] == 2 && $data['dispatch_qty'] > $orderData->qty):
                return ['status'=>0,'message'=>['dispatch_qty'=>'Invalid Qty.']];
            endif;

            if($data['trans_status'] == 3 && $orderData->trans_status > 0):
                return ['status'=>0,'message'=>'Order has been accepted/rejected. you can not cancel it.'];
            endif;

            if(in_array($data['trans_status'],[1,3,4])):
                $data['order_accpetd_at'] = date("Y-m-d H:i:s");
            endif;

            if($data['trans_status'] == 2):
                $data['net_amount'] = round(($data['dispatch_qty'] * $orderData->price),2);
                $data['order_completed_at'] = date("Y-m-d H:i:s");
            endif;

            $result = $this->store($this->orderTrans,$data);

            /* Send Notification */
            $notifyData = array();
            if($data['trans_status'] == 1): 
                $message = "Accepted"; 

                $notifyData['notificationTitle'] = "Order Accepted";
                $notifyData['notificationMsg'] = "Your order has been accepted.\nOrd. No. : ".$orderData->trans_number;
                $notifyData['user_ids'] = [$orderData->vou_acc_id];
            endif;

            if($data['trans_status'] == 2): 
                $message = "Delivered"; 

                $notifyData['notificationTitle'] = "Order Completed";
                $notifyData['notificationMsg'] = "Your order has been completed.\nOrd. No. : ".$orderData->trans_number;
                $notifyData['user_ids'] = [$orderData->vou_acc_id];
            endif;

            if($data['trans_status'] == 3): 
                $message = "Canceled"; 

                $notifyData['notificationTitle'] = "Order Canceled";
                $notifyData['notificationMsg'] = "Your order has been canceled.\nOrd. No. : ".$orderData->trans_number;
                $notifyData['user_ids'] = [$orderData->party_id];
            endif;
            
            if($data['trans_status'] == 4): 
                $message = "Rejected"; 

                $notifyData['notificationTitle'] = "Order Rejected";
                $notifyData['notificationMsg'] = "Your order has been rejected.\nOrd. No. : ".$orderData->trans_number;
                $notifyData['user_ids'] = [$orderData->vou_acc_id];
            endif;

            $result['message'] = "Order ".$message." Successfully.";

            $notifyData['callBack'] = base_url("app/myOrders");            
            $this->notify($notifyData);

            if ($this->db->trans_status() !== FALSE):
                $this->db->trans_commit();
                return $result;
            endif;
        }catch(\Throwable $e){
            $this->db->trans_rollback();
            return ['status'=>2,'message'=>"somthing is wrong. Error : ".$e->getMessage()];
        }
    }
}
?>