<?php
class ReportModel extends MasterModel{
    public function getLedgerList($data){
        $data['tableName'] = "user_master";
        $data['select'] = "user_master.id,user_master.user_code,user_master.user_name,ifnull(ledger.cl_balance,0) as cl_balance, ifnull(ledger.balance_type,'') as balance_type";

        $ledgerDate = "";
        if(!empty($data['filters'])):
            if(!empty($data['filters']['to_date'])):
                $ledgerDate = "AND trans_date <= '".$data['filters']['to_date']."'";
            endif;
        else:
            $ledgerDate = "AND trans_date <= '".date("Y-m-d")."'";
        endif;

        $data['leftJoin']["(SELECT party_id,abs(SUM(net_amount * p_or_m)) as cl_balance, (CASE WHEN SUM(net_amount * p_or_m) > 0 THEN 'Cr' WHEN SUM(net_amount * p_or_m) < 0 THEN 'Dr' ELSE '' END) as balance_type FROM order_transaction WHERE ((entry_type = 5 AND trans_status = 2) OR (entry_type = 6)) ".$ledgerDate." AND is_delete = 0 GROUP BY party_id) as ledger"] = "ledger.party_id = user_master.id";  
        
        $data['where']['user_master.user_role >'] = 1;

        $data['searchCol'][] = "user_master.user_code";
        $data['searchCol'][] = "user_master.user_name";
        //$data['searchCol'][] = "SUM(order_transaction.amount * order_transaction.p_or_m)";

        $data['order_by']['user_master.user_name'] = "ASC";

		return $this->pagingRows($data);
    }

    public function getLedgerBalance($data){
        if(!empty($data['filters'])):
            if(!empty($data['filters']['from_date'])):
                $from_date = $data['filters']['from_date'];
            endif;

            if(!empty($data['filters']['to_date'])):
                $to_date = $data['filters']['to_date'];
            endif;
        else:
            $from_date = date('Y-m-d', strtotime('-120 days'));
            $to_date = date('Y-m-d');
        endif;

        $result = $this->db->query("SELECT abs(ifnull(lb.op_balance,0)) as op_balance, (CASE WHEN lb.op_balance > 0 THEN 'Cr' WHEN lb.op_balance < 0 THEN 'Dr' ELSE '' END) as op_balance_type,abs(ifnull(lb.cl_balance,0)) as cl_balance, (CASE WHEN lb.cl_balance > 0 THEN 'Cr' WHEN lb.cl_balance < 0 THEN 'Dr' ELSE '' END) as cl_balance_type FROM (SELECT SUM((CASE WHEN trans_date < '".$from_date."' THEN (net_amount * p_or_m) ELSE 0 END)) as op_balance,SUM((CASE WHEN trans_date <= '".$to_date."'  THEN (net_amount * p_or_m) ELSE 0 END)) as cl_balance FROM order_transaction WHERE is_delete = 0  AND party_id = ".$data['party_id'].") as lb ")->row();
        //$this->printQuery();
        return $result;
    }

    public function getLedgerTrans($data){
        $data['tableName'] = "order_transaction";
        $data['select'] = "order_transaction.trans_number,DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y') as trans_date,order_transaction.net_amount,IF(order_transaction.net_amount > 0,order_transaction.c_or_d,'') as c_or_d,ifnull(order_transaction.remark,'') as remark,(CASE WHEN entry_type = 5 THEN 'Order' WHEN entry_type = 6 THEN 'Payment' ELSE '' END) as entry_name";

        if(!empty($data['filters'])):
            if(!empty($data['filters']['from_date'])):
                $data['where']['trans_date >='] = $data['filters']['from_date'];
            endif;

            if(!empty($data['filters']['to_date'])):
                $data['where']['trans_date <='] = $data['filters']['to_date'];
            endif;
        else:
            $data['where']['order_transaction.trans_date >='] = date('Y-m-d', strtotime('-120 days'));
            $data['where']['order_transaction.trans_date <='] = date('Y-m-d');
        endif;

        $data['where']['party_id'] = $data['party_id'];
        $data['customWhere'][] = "((entry_type = 5 AND trans_status = 2) OR (entry_type = 6))";

        $data['searchCol'][] = "order_transaction.trans_no";
        $data['searchCol'][] = "DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y')";
        $data['searchCol'][] = "order_transaction.net_amount";
        $data['searchCol'][] = "order_transaction.remark";
        $data['searchCol'][] = "(CASE WHEN entry_type = 5 THEN 'Order' WHEN entry_type = 6 THEN 'Payment' ELSE '' END)";

        $data['order_by']['order_transaction.trans_date'] = "ASC";
        $data['order_by']['order_transaction.trans_no'] = "ASC";

		return $this->pagingRows($data);
    }
}
?>