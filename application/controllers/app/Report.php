<?php
class Report extends MY_Controller{
    private $ledger = "app/report/ledger";
    private $ledgerDetail = "app/report/ledger_detail";

    public function __construct(){
        parent::__construct();
        $this->data['headData']->controller = "report";
        $this->data['headData']->pageName = "";
    }

    public function ledgers(){
        $this->data['headData']->pageName = "Kariger Ledger";
        $this->load->view($this->ledger,$this->data);
    }

    public function getLedgerList(){
        $data = $this->input->post();
        $result = $this->report->getLedgerList($data);
        $this->printJson($result);
    }

    public function ledgerDetail($id){
        $userData = $this->userMaster->getUser(['id'=>$id]);
        $this->data['headData']->pageName = $userData->user_name;
        $this->data['userData'] = $userData;
        $this->load->view($this->ledgerDetail,$this->data);
    }

    public function getLedgerDetail($id){
        $data = $this->input->post();
        $data['party_id'] = $id;
        $result = $this->report->getLedgerTrans($data);
        $result["ledgerData"] = $this->report->getLedgerBalance($data);
        $this->printJson($result);
    }

    public function printLedgerSummary($jsonData){
        $data = (Array) decodeURL($jsonData);
        $data['is_print'] = 1;
        $data['filters']['to_date'] = $data['to_date'];
        $LedgerList = $this->report->getLedgerList($data);
        $pdfData = "";

        $tbody = '';
        if(!empty($LedgerList)):
            $i=1;
            foreach($LedgerList as $row):
                $tbody .= '<tr>
                    <td>'.$i.'</td>
                    <td>'.$row->user_code.'</td>
                    <td>'.$row->user_name.'</td>
                    <td class="text-right">'.$row->cl_balance.' '.$row->balance_type.'</td>
                </tr>';
                $i++;
            endforeach;
        else:
            $tbody .= '<tr>
                <td colspan="4" class="text-center">No data available</td>
            </tr>';
        endif;

        $pdfData .= '<html>
            <head>
                <title>Ledger Summary Report</title>
            </head>
            <body>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" class="text-center fs-px-30 border-bottom">SSCY</th>
                    </tr>
                    <tr>
                        <th class="text-left">
                            Ledger Summary Report
                        </th>
                        <th class="text-right">
                            Date : '.formatDate($data['to_date']).'
                        </th>
                    </tr>
                </table>

                <table class="table table-bordered m-t-10">
                    <thead>
                        <tr>
                            <th class="text-left">Sr. No.</th>
                            <th class="text-left">Kariger Code</th>
                            <th class="text-left">Kariger Name</th>
                            <th class="text-right">Closing Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$tbody.'
                    </tbody>
                </table>
            </body>
        </html>';

        $htmlFooter = '<table class="table top-table" style="margin-top:10px;border-top:1px solid #545454;">
            <tr>
                <td style="width:25%;">Print Date : '.date("d-m-Y").'</td>
                <td style="width:25%;"></td>
                <td style="width:25%;text-align:right;">Page No. {PAGENO}/{nbpg}</td>
            </tr>
        </table>';
        
        $logo = base_url('assets/dist/img/logo.png');
        
        $mpdf = new \Mpdf\Mpdf();
        $filePath = realpath(APPPATH . '../assets/uploads/report/');
        $pdfFileName = str_replace(["/","-"],"_","ledger_summary_".$data['to_date']) . '.pdf';

        $stylesheet = file_get_contents(base_url('assets/css/pdf-style.css?v='.time()));
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkImage($logo, 0.03, array(120, 120));
        $mpdf->showWatermarkImage = true;
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->AddPage('P','','','','',10,5,5,15,5,5,'','','','','','','','','','A4-P');
        $mpdf->WriteHTML($pdfData);
        
        ob_clean();
        $mpdf->Output($pdfFileName, 'D');
    }

    public function printLedgerDetail($jsonData){
        $data = (Array) decodeURL($jsonData);
        $data['is_print'] = 1;
        $data['filters']['from_date'] = $data['from_date'];
        $data['filters']['to_date'] = $data['to_date'];
        $ledgerTransaction = $this->report->getLedgerTrans($data);
        $ledgerBalance = $this->report->getLedgerBalance($data);
        $userData = $this->userMaster->getUser(['id'=>$data['party_id']]);
        $pdfData = "";

        $tbody = '';$balance = $ledgerBalance->opb; 
        if(!empty($ledgerTransaction)):
            $i=1; $crTotal = $drTotal = 0;
            foreach($ledgerTransaction as $row):
                $balance += ($row->net_amount * $row->p_or_m);
                $balanceType = "";
                if($balance > 0): $balanceType = "Cr."; elseif($balance < 0 ): $balanceType = "Dr."; endif;

                $tbody .= '<tr>
                    <td>'.$i.'</td>
                    <td>'.$row->entry_name.'</td>
                    <td>'.$row->trans_number.'</td>
                    <td>'.$row->trans_date.'</td>
                    <td class="text-right">'.$row->cr_amount.'</td>
                    <td class="text-right">'.$row->dr_amount.'</td>
                    <td class="text-right">'.abs($balance).' '.$balanceType.'</td>
                </tr>';
                $i++;

                $crTotal += $row->cr_amount;
                $drTotal += $row->dr_amount;
            endforeach;

            $balanceType = "";
            if($balance > 0): $balanceType = "Cr."; elseif($balance < 0 ): $balanceType = "Dr."; endif;
        else:
            $tbody .= '<tr>
                <td colspan="7" class="text-center">No data available</td>
            </tr>';
        endif;

        $pdfData .= '<html>
            <head>
                <title>Ledger Detail Report</title>
            </head>
            <body>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" class="text-center fs-px-30 border-bottom">SSCY</th>
                    </tr>
                    <tr>
                        <th class="text-left">
                            Kariger Name : '.$userData->user_name.'
                        </th>
                        <th class="text-right">
                            Date : '.formatDate($data['from_date']).' to '.formatDate($data['to_date']).'
                        </th>
                    </tr>
                </table>

                <table class="table table-bordered  m-t-10">
                    <tr>
                        <th class="text-right">Op. Balance : '.$ledgerBalance->op_balance.' '.$ledgerBalance->op_balance_type.'</th>
                    </tr>
                </table>
                <table class="table table-bordered m-t-10">
                    <thead>
                        <tr>
                            <th class="text-left">Sr. No.</th>
                            <th class="text-left">Vou. Type</th>
                            <th class="text-left">Vou. No.</th>
                            <th class="text-left">Vou. Date</th>
                            <th class="text-right">Cr. Amount</th>
                            <th class="text-right">Dr. Amount</th>
                            <th class="text-right">Balance Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$tbody.'
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th class="text-right">'.$crTotal.'</th>
                            <th class="text-right">'.$drTotal.'</th>
                            <th class="text-right">'.abs($balance).' '.$balanceType.'</th>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-bordered  m-t-10">
                    <tr>
                        <th class="text-right">Cl. Balance : '.$ledgerBalance->cl_balance.' '.$ledgerBalance->cl_balance_type.'</th>
                    </tr>
                </table>
            </body>
        </html>';

        $htmlFooter = '<table class="table top-table" style="margin-top:10px;border-top:1px solid #545454;">
            <tr>
                <td style="width:25%;">Print Date : '.date("d-m-Y").'</td>
                <td style="width:25%;"></td>
                <td style="width:25%;text-align:right;">Page No. {PAGENO}/{nbpg}</td>
            </tr>
        </table>';
        
        $logo = base_url('assets/dist/img/logo.png');
        
        $mpdf = new \Mpdf\Mpdf();
        $filePath = realpath(APPPATH . '../assets/uploads/report/');
        $pdfFileName = str_replace(["/","-"],"_","ledger_detail_".$data['to_date']) . '.pdf';

        $stylesheet = file_get_contents(base_url('assets/css/pdf-style.css?v='.time()));
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkImage($logo, 0.03, array(120, 120));
        $mpdf->showWatermarkImage = true;
        $mpdf->SetHTMLFooter($htmlFooter);
        $mpdf->AddPage('P','','','','',10,5,5,15,5,5,'','','','','','','','','','A4-P');
        $mpdf->WriteHTML($pdfData);
        
        ob_clean();
        $mpdf->Output($pdfFileName, 'D');
    }
}
?>