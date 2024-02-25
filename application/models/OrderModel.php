<?php
class OrderModel extends masterModel{
    private $orderTrans = "order_transaction";

    public function getDTRows($data){
        $data['tableName'] = $this->orderTrans;
        $data['select'] = "order_transaction.*,item_master.item_code,item_master.item_name,IF(item_master.item_image != '',CONCAT('".base_url('assets/uploads/products/')."',item_master.item_image),'".base_url("assets/dist/img/app-img/sample/brand/1.jpg")."') as item_image,item_group.group_name,category_master.category_name,(CASE WHEN order_transaction.trans_status = 0 THEN 'Pending' WHEN order_transaction.trans_status = 1 THEN 'Accepted' WHEN order_transaction.trans_status = 2 THEN 'Competed' WHEN order_transaction.trans_status = 3 THEN 'Cancled' WHEN order_transaction.trans_status = 4 THEN 'Rejected' ELSE '' END) as order_status,DATE_FORMAT(order_transaction.trans_date,'d%-m%-Y%') as trans_date,DATE_FORMAT(order_transaction.delivery_date,'d%-m%-Y%') as delivery_date";

        $data['leftJoin']['item_master'] = "item_master.id = order_transaction.item_id";
        $data['leftJoin']['item_group'] = "item_group.id = order_transaction.group_id";
        $data['leftJoin']['category_master'] = "category_master.id = order_transaction.category_id";

        if($this->userRole > 1):
            $data['where']['order_transaction.party_id'] = $this->loginId;
        endif;

        /* if(!empty($data['filters'])):
            if(!empty($data['filters']['item_code'])):
                $data['where']['item_master.item_code'] = $data['filters']['item_code'];
            endif;

            if(!empty($data['filters']['group_id'])):
                $data['where']['item_master.group_id'] = $data['filters']['group_id'];
            endif;
        endif; */

        $data['searchCol'][] = "order_transaction.trans_number";
        $data['searchCol'][] = "DATE_FORMAT(order_transaction.trans_date,'d%-m%-Y%')";
        $data['searchCol'][] = "DATE_FORMAT(order_transaction.delivery_date,'d%-m%-Y%')";
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
        $queryData['select'] = "ifnull(MAX(trans_no),1) as trans_no";
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