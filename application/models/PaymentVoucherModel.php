<?php
class PaymentVoucherModel extends MasterModel{
    private $paymentTrans = "order_transaction";

    public function getDTRows($data){
        $data['tableName'] = $this->paymentTrans;
        $data['select'] = "order_transaction.*,DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y') as trans_date";

        if($this->userRole > 1):
            $data['where']['order_transaction.party_id'] = $this->loginId;
        endif;

        $data['where']['order_transaction.entry_type'] = 6;

        $data['searchCol'][] = "order_transaction.trans_number";
        $data['searchCol'][] = "DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y')";
        $data['searchCol'][] = "order_transaction.amount";
        $data['searchCol'][] = "order_transaction.remark";

        $data['order_by']['order_transaction.trans_no'] = "DESC";

		return $this->pagingRows($data);
    }

    public function getNextNo($entry_type){
        $queryData = array();
        $queryData['tableName'] = $this->paymentTrans;
        $queryData['select'] = "ifnull((MAX(trans_no) + 1),1) as trans_no";
        $queryData['where']['entry_type'] = $entry_type;
        $queryData['where']['party_id'] = $this->loginId;
        $result = $this->row($queryData);
        return $result->trans_no;
    }

    public function save($data){
        try{
            $this->db->trans_begin();

            if(empty($data['id'])):
                $data['entry_type'] = 6;
                $data['trans_prefix'] = "#";
                $data['trans_no'] = $this->getNextNo($data['entry_type']);
                $data['trans_number'] = $data['trans_prefix'].$data['trans_no'];
            endif;

            $data['party_id'] = $this->loginId;
            $data['opp_acc_id'] = $data['party_id'];
            $data['net_amount'] = $data['amount'];
            $data['p_or_m'] = -1;
            $data['c_or_d'] = 'Dr';

            $result = $this->store($this->paymentTrans,$data,'Voucher');

            if ($this->db->trans_status() !== FALSE):
                $this->db->trans_commit();
                return $result;
            endif;
        }catch(\Throwable $e){
            $this->db->trans_rollback();
            return ['status'=>2,'message'=>"somthing is wrong. Error : ".$e->getMessage()];
        }	
    }

    public function getPaymentVoucher($data){
        $queryData = array();
        $queryData['tableName'] = $this->paymentTrans;
        $queryData['where']['id'] = $data['id'];
        $result = $this->row($queryData);
        return $result;
    }

    public function delete($id){
        try{
            $this->db->trans_begin();

            $result = $this->trash($this->paymentTrans,['id'=>$id],'Voucher');

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