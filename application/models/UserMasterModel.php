<?php
class UserMasterModel extends MasterModel{
    private $userMaster = "user_master";

    public function getDTRows($data){
        $data['tableName'] = $this->userMaster;
        $data['select'] = "user_master.*,IF(user_image IS NOT NULL,CONCAT('".base_url('assets/uploads/user_image/')."',user_image),'".base_url("assets/dist/img/avatar.png")."') as user_image";

        $data['where']['is_active'] = $data['is_active'];
        $data['where']['user_role !='] = -1;

        $data['searchCol'][] = "user_name";
        $data['searchCol'][] = "user_code";
        $data['searchCol'][] = "mobile_no";

        $data['order_by']['id'] = "DESC";

		return $this->pagingRows($data);
    }

    public function save($data){
        try{
            $this->db->trans_begin();

            if(empty($data['form_type'])):
                $errorMessage = array();
                if($this->checkDuplicate(['id'=>$data['id'],'user_code'=>$data['user_code']]) > 0):
                    $errorMessage['user_code'] = "Kariger Code is duplicate.";
                endif;
                if($this->checkDuplicate(['id'=>$data['id'],'mobile_no'=>$data['mobile_no']]) > 0):
                    $errorMessage['mobile_no'] = "Mobile No. is duplicate.";
                endif;

                if(!empty($errorMessage)):
                    return ['status'=>0,'message'=>$errorMessage];
                endif;
            else:
                unset($data['form_type']);
            endif;

            $result = $this->store($this->userMaster,$data,'Kariger');

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
        $queryData['tableName'] = $this->userMaster;

        if(!empty($data['user_code']))
            $queryData['where']['user_code'] = $data['user_code'];

        if(!empty($data['mobile_no']))
            $queryData['where']['mobile_no'] = $data['mobile_no'];

        if(!empty($data['id']))
            $queryData['where']['id !='] = $data['id'];

        $queryData['resultType'] = "numRows";
        return $this->specificRow($queryData);
    }

    public function getUser($data){
        $queryData = array();
        $queryData['tableName'] = $this->userMaster;
        $queryData['select'] = "user_master.*,IF(user_image IS NOT NULL,CONCAT('".base_url('assets/uploads/user_image/')."',user_image),'".base_url("assets/dist/img/avatar.png")."') as user_image";

        if(!empty($data['id']))
            $queryData['where']['id'] = $data['id'];
        
        if(!empty($data['user_code']))
            $queryData['where']['user_code'] = $data['user_code'];

        $result = $this->row($queryData);
        return $result;
    }

    public function getUserList(){
        $queryData = array();
        $queryData['tableName'] = $this->userMaster;
        $queryData['where']['is_active'] = 1;
        $queryData['where']['user_role !='] = -1;
        $result = $this->rows($queryData);
        return $result;
    }

    public function changeStatus($data){
        try{
            $this->db->trans_begin();

            $result = $this->store($this->userMaster,$data,'Kariger');
            $result['message'] = "Kariger ".(($data['is_active'] == 0)?"In-Actived":"Actived")." Successfully";

            if ($this->db->trans_status() !== FALSE):
                $this->db->trans_commit();
                return $result;
            endif;
        }catch(\Throwable $e){
            $this->db->trans_rollback();
            return ['status'=>2,'message'=>"somthing is wrong. Error : ".$e->getMessage()];
        }	
    }

    public function delete($id){
        try{
            $this->db->trans_begin();

            $checkData['columnName'] = ["party_id","created_by"];
            $checkData['value'] = $id;
            $checkUsed = $this->checkUsage($checkData);

            if($checkUsed == true):
                return ['status'=>0,'message'=>'The kariger is currently in use. you cannot delete it.'];
            endif;

            $result = $this->trash($this->userMaster,['id'=>$id],'Kariger');

            if ($this->db->trans_status() !== FALSE):
                $this->db->trans_commit();
                return $result;
            endif;
        }catch(\Throwable $e){
            $this->db->trans_rollback();
            return ['status'=>2,'message'=>"somthing is wrong. Error : ".$e->getMessage()];
        }	
    }

    public function saveChangePassword($data){
        try{
            $this->db->trans_begin();

            $data['id'] = $this->loginId;unset($data['old_password']);
            $result = $this->store($this->userMaster,$data,'Password');

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