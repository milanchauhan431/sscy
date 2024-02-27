<?php 
    if($this->userRole <= 1): 
        $this->load->view('app/includes/admin_sidebar');
    else:
        $this->load->view('app/includes/kariger_sidebar');
    endif;
?>