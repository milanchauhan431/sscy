<html>
    <head>
        <title>Order List</title>
    </head>
    <body>
        <table class="table table-bordered">
            <tr>
                <th colspan="2" class="text-center fs-px-30 border-bottom">SSCY</th>
            </tr>
            <tr>
                <th class="text-left">
                    Kariger Name : <?=$userDetail->user_name?>
                </th>
                <th class="text-right">
                    Date : <?=formatDate($printDate)?>
                </th>
            </tr>
        </table>

        <table class="table table-bordered m-t-10">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Group</th>
                    <th>Product Category</th>
                    <th>Order No.</th>
                    <th>Order Qty.</th>
                    <th>Order Status</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($orderList)):
                        $i=1;
                        foreach($orderList as $row):
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td><img src="'.$row->item_image.'" class="image-block imaged w48" alt="img"></td>
                                <td>'.$row->item_name.'</td>
                                <td>'.$row->group_name.'</td>
                                <td>'.$row->category_name.'</td>
                                <td>'.$row->trans_number.'</td>
                                <td>'.$row->qty.'</td>
                                <td>'.$row->order_status.'</td>
                                <td>'.$row->remark.'</td>
                            </tr>';
                            $i++;
                        endforeach;
                    else:
                        echo '<tr>
                            <td colspan="9" class="text-center">No data available</td>
                        </tr>';
                    endif;
                ?>
            </tbody>
        </table>
    </body>
</html>