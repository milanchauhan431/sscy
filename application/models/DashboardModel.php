<?php
class DashboardModel extends MasterModel{
    private $orderTrans = "order_transaction";

    public function getTopOrderItems(){
        $queryData = array();
        $queryData['tableName'] = $this->orderTrans;
        $queryData['select'] = "item_master.item_code,item_master.item_name,IF(item_master.item_image != '',CONCAT('".base_url('assets/uploads/products/')."',item_master.item_image),'".base_url("assets/dist/img/app-img/sample/brand/1.jpg")."') as item_image,item_group.group_name,category_master.category_name,SUM(order_transaction.qty) as qty";

        $queryData['leftJoin']['item_master'] = "item_master.id = order_transaction.item_id";
        $queryData['leftJoin']['item_group'] = "item_group.id = order_transaction.group_id";
        $queryData['leftJoin']['category_master'] = "category_master.id = order_transaction.category_id";

        $queryData['where']['entry_type'] = 5;
        
        $queryData['group_by'][] = "order_transaction.item_id";
        $queryData['group_by'][] = "order_transaction.group_id";
        $queryData['group_by'][] = "order_transaction.category_id";

        $queryData['order_by']['SUM(order_transaction.qty)'] = "DESC";

        $queryData['limit'] = "10";

        $result = $this->rows($queryData);
        return $result;
    }

    public function getPendingOrderList(){
        $queryData['tableName'] = $this->orderTrans;
        $queryData['select'] = "order_transaction.*,item_master.item_code,item_master.item_name,IF(item_master.item_image != '',CONCAT('".base_url('assets/uploads/products/')."',item_master.item_image),'".base_url("assets/dist/img/app-img/sample/brand/1.jpg")."') as item_image,item_group.group_name,category_master.category_name,(CASE WHEN order_transaction.trans_status = 0 THEN 'Pending' WHEN order_transaction.trans_status = 1 THEN 'Accepted' WHEN order_transaction.trans_status = 2 THEN 'Competed' WHEN order_transaction.trans_status = 3 THEN 'Cancled' WHEN order_transaction.trans_status = 4 THEN 'Rejected' ELSE '' END) as order_status,DATE_FORMAT(order_transaction.trans_date,'%d-%m-%Y') as trans_date";

        $queryData['leftJoin']['item_master'] = "item_master.id = order_transaction.item_id";
        $queryData['leftJoin']['item_group'] = "item_group.id = order_transaction.group_id";
        $queryData['leftJoin']['category_master'] = "category_master.id = order_transaction.category_id";

        $queryData['where']['order_transaction.party_id'] = $this->loginId;
        $queryData['where']['order_transaction.trans_status'] = 0;

        $queryData['order_by']['order_transaction.trans_no'] = "DESC";

		return $this->rows($queryData);
    }
}
?>