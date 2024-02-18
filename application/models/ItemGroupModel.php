<?php
class ItemGroupModel extends MasterModel{
    private $itemGroup = "item_group";

    public function getDTRows($data){
        $data['tableName'] = $this->itemGroup;
        $data['select'] = "item_group.*";

        $data['searchCol'][] = "group_name";
        $data['searchCol'][] = "remark";

        $data['order_by']['id'] = "DESC";

		return $this->pagingRows($data);
    }

    public function save($data){
        try{
            $this->db->trans_begin();

            if($this->checkDuplicate($data) > 0):
                return ['status'=>0,'message'=>['group_name' => "Group name is duplicate."]];
            endif;

            $result = $this->store($this->itemGroup,$data,'Product Group');

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
        $queryData['tableName'] = $this->itemGroup;

        if(!empty($data['group_name']))
            $queryData['where']['group_name'] = $data['group_name'];

        if(!empty($data['id']))
            $queryData['where']['id !='] = $data['id'];

        $queryData['resultType'] = "numRows";
        return $this->specificRow($queryData);
    }

    public function getItemGroup($data){
        $queryData = array();
        $queryData['tableName'] = $this->itemGroup;
        $queryData['where']['id'] = $data['id'];
        $result = $this->row($queryData);
        return $result;
    }

    public function getItemGroupList(){
        $queryData = array();
        $queryData['tableName'] = $this->itemGroup;
        $result = $this->rows($queryData);
        return $result;
    }

    public function delete($id){
        try{
            $this->db->trans_begin();

            $checkData['columnName'] = ["group_id"];
            $checkData['value'] = $id;
            $checkUsed = $this->checkUsage($checkData);

            if($checkUsed == true):
                return ['status'=>0,'message'=>'The Product Group is currently in use. you cannot delete it.'];
            endif;

            $result = $this->trash($this->itemGroup,['id'=>$id],'Product Group');

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