<?php
class OrderModel extends masterModel{
    private $orderTrans = "order_transaction";

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