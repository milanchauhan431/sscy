<?php
class ItemCategoryModel extends MasterModel{
    private $itemCategory = "category_master";

    public function getDTRows($data){
        $data['tableName'] = $this->itemCategory;
        $data['select'] = "category_master.*";

        $data['where']['created_by'] = $this->loginId;

        $data['searchCol'][] = "category_name";
        $data['searchCol'][] = "remark";

        $data['order_by']['id'] = "DESC";

		return $this->pagingRows($data);
    }

    public function save($data){
        try{
            $this->db->trans_begin();

            if($this->checkDuplicate($data) > 0):
                return ['status'=>0,'message'=>['category_name' => "Category name is duplicate."]];
            endif;

            $result = $this->store($this->itemCategory,$data,'Item Category');

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
        $queryData['tableName'] = $this->itemCategory;

        if(!empty($data['category_name']))
            $queryData['where']['category_name'] = $data['category_name'];

        if(!empty($data['id']))
            $queryData['where']['id !='] = $data['id'];

        $queryData['where']['created_by'] = $this->loginId;

        $queryData['resultType'] = "numRows";
        return $this->specificRow($queryData);
    }

    public function getItemCategory($data){
        $queryData = array();
        $queryData['tableName'] = $this->itemCategory;
        $queryData['where']['id'] = $data['id'];
        $result = $this->row($queryData);
        return $result;
    }

    public function getItemCategoryList(){
        $queryData = array();
        $queryData['tableName'] = $this->itemCategory;
        $queryData['where']['created_by'] = $this->loginId;
        $result = $this->rows($queryData);
        return $result;
    }

    public function delete($id){
        try{
            $this->db->trans_begin();

            $checkData['columnName'] = ["category_id"];
            $checkData['value'] = $id;
            $checkUsed = $this->checkUsage($checkData);

            if($checkUsed == true):
                return ['status'=>0,'message'=>'The Item Category is currently in use. you cannot delete it.'];
            endif;

            $result = $this->trash($this->itemCategory,['id'=>$id],'Item Category');

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