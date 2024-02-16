<?php
class ItemMaster extends MY_Controller{
    public $index = "app/item_master/index";
    public $form = "app/item_master/form";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "itemMaster";
        $this->data['headData']->pageName = "Products";
    }

    public function index(){
        $this->load->view($this->index,$this->data);
    }

    public function getDTRows(){
        $data = $this->input->post();
        $result = $this->item->getDTRows($data);
        $this->printJson($result);
    }

    public function addItem(){
        $this->data['itemCategoryList'] = $this->itemCategory->getItemCategoryList();
        $this->load->view($this->form,$this->data);
    }

    public function save(){
        $data = $this->input->post();
        $errorMessage = array();

        if(empty($data['item_name']))
            $errorMessage['item_name'] = "Product name is required.";
        if(empty($data['category_id']))
            $errorMessage['category_id'] = "Category name is required.";

        if(!empty($errorMessage)):
            $this->printJson(['status'=>0,'message'=>$errorMessage]);
        else:
            if(!empty($_FILES['item_image']['name'])):
                $this->load->library('upload');
                $this->load->library('image_lib');

                $errorMessage['item_imgae_error'] = "";

                $_FILES['userfile']['name']     = $_FILES['item_image']['name'];
                $_FILES['userfile']['type']     = $_FILES['item_image']['type'];
                $_FILES['userfile']['tmp_name'] = $_FILES['item_image']['tmp_name'];
                $_FILES['userfile']['error']    = $_FILES['item_image']['error'];
                $_FILES['userfile']['size']     = $_FILES['item_image']['size'];

                $imagePath = realpath(APPPATH . '../assets/uploads/products/');

                $fileName = preg_replace('/[^A-Za-z0-9]+/', '_', strtolower($_FILES['item_image']['name']));
                $config = ['file_name' => time() . "_PRD_" . $fileName, 'allowed_types' => 'jpg|jpeg|png|gif|JPG|JPEG|PNG', 'max_size' => 10240, 'overwrite' => FALSE, 'upload_path' => $imagePath];

                $this->upload->initialize($config);

                if(!$this->upload->do_upload()):
                    $errorMessage['item_image_error'] .= $fileName . " => " . $this->upload->display_errors();
                else:
                    $uploadData = $this->upload->data();
                    $attachment = $uploadData['file_name'];

                    $imgConfig['image_library'] = 'gd2';
                    $imgConfig['source_image'] = $uploadData['full_path'];
                    $imgConfig['maintain_ratio'] = TRUE;
                    $imgConfig['width'] = 640;
                    $imgConfig['height'] = 480;
                    $imgConfig['quality'] = "50%";

                    $this->image_lib->clear();
                    $this->image_lib->initialize($imgConfig);

                    if (!$this->image_lib->resize()) :
                        $errorMessage['item_imgae_error'] .= $fileName . " => " . $this->image_lib->display_errors();
                    endif;
                endif;

                if(!empty($errorMessage['item_image_error'])):
                    if (file_exists($imagePath . '/' . $attachment)) : unlink($imagePath . '/' . $attachment); endif;
                    $this->printJson(['status' => 0, 'message' => $errorMessage]);
                endif;

                $data['item_image'] = $attachment;
            endif;

            $this->printJson($this->item->save($data));
        endif;
    }

    public function edit(){
        $data = $this->input->post();
        $this->data['itemCategoryList'] = $this->itemCategory->getItemCategoryList();
        $this->data['dataRow'] = $this->item->getItem($data);
        $this->load->view($this->form,$this->data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(empty($id)):
            $this->printJson(['status'=>0,'message'=>'Somthing went wrong...Please try again.']);
        else:
            $this->printJson($this->item->delete($id));
        endif;
    }
}
?>