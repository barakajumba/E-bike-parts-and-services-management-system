<?php if($_settings->chk_flashdata('success')): ?>
<script>
    // Display success message as a toast
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header bg-dark text-light">
        <h3 class="card-title">Product Stocks</h3>
        <div class="card-tools">
            <!-- Add new stock button -->
            <a href="javascript:void(0)" id="add_new" class="btn btn-primary"><span class="fas fa-plus"></span>  Add New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped" style="font-family: 'Roboto', sans-serif;">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="25%">
                    <col width="25%">
                    <col width="10%">
                    <col width="15%">
                </colgroup>
                <thead class="bg-dark text-light">
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Brand</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT p.*, b.name as brand FROM `product_list` p INNER JOIN brand_list b ON p.brand_id = b.id WHERE p.delete_flag = 0 ORDER BY (p.`name`) ASC ");
                    while($row = $qry->fetch_assoc()):
                        $row['stocks'] = $conn->query("SELECT SUM(quantity) FROM stock_list WHERE product_id = '{$row['id']}'")->fetch_array()[0];
                        $row['out'] = $conn->query("SELECT SUM(quantity) FROM order_items WHERE product_id = '{$row['id']}' AND order_id IN (SELECT id FROM order_list WHERE `status` != 5)")->fetch_array()[0];
                        $row['stocks'] = $row['stocks'] > 0 ? $row['stocks'] : 0;
                        $row['out'] = $row['out'] > 0 ? $row['out'] : 0;
                        $row['available'] = $row['stocks'] - $row['out'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                        <td><?php echo ucwords($row['brand']) ?></td>
                        <td><?php echo ucwords($row['name']) ?></td>
                        <td class="text-right"><?= number_format($row['available']) ?></td>
                        <td align="center">
                            <!-- Dropdown button for actions -->
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <!-- View product stock details -->
                                    <a class="dropdown-item" href="?page=inventory/view_stock&id=<?php echo $row['id'] ?>">
                                        <span class="fa fa-eye text-dark"></span> View
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
        // Open modal to add new stock
        $('#add_new').click(function(){
            uni_modal("Add New Stock","inventory/manage_stock.php")
        });

        // Delete product function
        $('.delete_data').click(function(){
            _conf("Are you sure to delete this product permanently?","delete_product",[$(this).attr('data-id')])
        });

        // Style table cells
        $('.table th, .table td').addClass("align-middle px-2 py-1");
        $('.table').dataTable();
        $('.table').dataTable();
    });

    // AJAX function to delete product
    function delete_product($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_product",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>
