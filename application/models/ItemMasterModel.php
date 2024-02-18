<?php
class ItemMasterModel extends MasterModel{
    private $itemMaster = "item_master";

    public function getDTRows($data){
        $data['tableName'] = $this->itemMaster;
        $data['select'] = "item_master.*,IF(item_master.item_image != '',CONCAT('".base_url('assets/uploads/products/')."',item_master.item_image),'".base_url("assets/dist/img/app-img/sample/brand/1.jpg")."') as item_image,item_group.group_name";

        $data['leftJoin']['item_group'] = "item_group.id = item_master.group_id";

        if($this->userRole > 1):
            $data['where']['item_master.created_by'] = $this->loginId;
        endif;

        $data['searchCol'][] = "item_master.item_code";
        $data['searchCol'][] = "item_master.item_name";
        $data['searchCol'][] = "item_master.price";
        $data['searchCol'][] = "item_group.group_name";

        $data['order_by']['item_master.id'] = "DESC";

		return $this->pagingRows($data);
    }

    public function save($data){
        try{
            $this->db->trans_begin();

            if($this->checkDuplicate($data) > 0):
                return ['status'=>0,'message'=>['item_name' => "Product name is duplicate."]];
            endif;

            if(!empty($data['item_image']) && !empty($data['id'])):
                $itemData = $this->getItem(['id'=>$data['id']]);
                if(!empty($itemData->item_image)):
                    $imagePath = realpath(APPPATH . '../assets/uploads/products/');
                    if (file_exists($imagePath . '/' . $itemData->item_image)) : 
                        unlink($imagePath . '/' . $itemData->item_image);
                    endif;
                endif;
            endif;            

            $result = $this->store($this->itemMaster,$data,'Product');

            if ($this->db->trans_status() !== FALSE):
                $this->db->trans_commit();
                return $result;
            endif;
        }catch(\Throwable $e){
            $this->db->trans_rollback();
            return ['status'=>2,'message'=>"somthing is wrong. Error : ".$e->getMessage()];
        }
    }

    public function checkDuplicate($data){
        $queryData['tableName'] = $this->itemMaster;

        if(!empty($data['item_name']))
            $queryData['where']['item_name'] = $data['item_name'];
        if(!empty($data['category_id']))
            $queryData['where']['category_id'] = $data['category_id'];

        if(!empty($data['id']))
            $queryData['where']['id !='] = $data['id'];

        $queryData['resultType'] = "numRows";
        return $this->specificRow($queryData);
    }

    public function getItem($data){
        $queryData = array();
        $queryData['tableName'] = $this->itemMaster;
        $queryData['select'] = "item_master.*,category_master.category_name";
        $queryData['leftJoin']['category_master'] = "category_master.id = item_master.category_id";
        $queryData['where']['item_master.id'] = $data['id'];
        $result = $this->row($queryData);
        return $result;
    }

    public function delete($id){
        try{
            $this->db->trans_begin();

            $checkData['columnName'] = ["item_id"];
            $checkData['value'] = $id;
            $checkUsed = $this->checkUsage($checkData);

            if($checkUsed == true):
                return ['status'=>0,'message'=>'The Product is currently in use. you cannot delete it.'];
            endif;

            $itemData = $this->getItem(['id'=>$id]);
            if(!empty($itemData->item_image)):
                $imagePath = realpath(APPPATH . '../assets/uploads/products/');
                if (file_exists($imagePath . '/' . $itemData->item_image)) : 
                    unlink($imagePath . '/' . $itemData->item_image);
                endif;
            endif;

            $result = $this->trash($this->itemMaster,['id'=>$id],'Product');

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