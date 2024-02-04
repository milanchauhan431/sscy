<?php
class UserMasterModel extends MasterModel{
    private $userMaster = "user_master";

    public function getDTRows($data){
        $data['tableName'] = $this->userMaster;
        $data['select'] = "user_master.*,IF(user_image IS NOT NULL,CONCAT('".base_url('app/uploads/user_image/')."',user_image),'".base_url("assets/dist/img/avatar.png")."') as user_image";

        $data['where']['is_active'] = $data['is_active'];
        $data['where']['user_role !='] = -1;

        $data['searchCol'][] = "user_name";
        $data['searchCol'][] = "user_code";
        $data['searchCol'][] = "mobile_no";

		return $this->pagingRows($data);
    }

}
?>