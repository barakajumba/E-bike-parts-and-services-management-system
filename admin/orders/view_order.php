<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
    }

    input[type="text"],
    input[type="number"],
    select {
        font-family: 'Roboto', sans-serif !important;
    }
</style>

<?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `order_list` where id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k))
            $$k = $v;
        }
    }
}
?>
<style>
    .prod-cart-img{
        width:7em;
        height:7em;
        object-fit:scale-down;
        object-position: center center;
    }
</style>
<div class="card card-outline card-dark shadow rounded0-0">
    <div class="card-header">
        <h3 class="card-title"><b>Order Details</b></h3>
        <div class="card-tools">
            <button class="btn btn-primary btn-flat btn-sm" type="button" id="update_status"><i class="fa fa-edit"></i> Update Status</button>
            <button class="btn btn-danger btn-flat btn-sm" type="button" id="delete_order"><i class="fa fa-trash"></i> Delete</button>
            <a class="btn btn-default btn-flat border btn-sm" href="./?page=orders"><i class="fa fa-angle-left"></i> Back to List</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="text-muted">Reference Code</label>
                    <div class="ml-3"><b><?= isset($ref_code) ? $ref_code : "N/A" ?></b></div>
                </div>
                <div class="col-md-6">
                    <label for="" class="text-muted">Date Ordered</label>
                    <div class="ml-3"><b><?= isset($date_created) ? date("M d, Y h:i A", strtotime($date_created)) : "N/A" ?></b></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="text-muted">Status</label>
                    <div class="ml-3">
                        <?php if(isset($status)): ?>
                            <?php if($status == 0): ?>
                                <span class="badge badge-secondary px-3 rounded-pill">Pending</span>
                            <?php elseif($status == 1): ?>
                                <span class="badge badge-primary px-3 rounded-pill">Packed</span>
                            <?php elseif($status == 2): ?>
                                <span class="badge badge-success px-3 rounded-pill">For Delivery</span>
                            <?php elseif($status == 3): ?>
                                <span class="badge badge-warning px-3 rounded-pill">On the Way</span>
                            <?php elseif($status == 4): ?>
                                <span class="badge badge-default bg-gradient-teal px-3 rounded-pill">Delivered</span>
                            <?php else: ?>
                                <span class="badge badge-danger px-3 rounded-pill">Cancelled</span>
                            <?php endif; ?>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="clear-fix my-2"></div>
            <div class="row">
                <div class="col-12">
                <div class="w-100" id="order-list">
                        <?php 
                        $total = 0;
                        if(isset($id)):
                        $order_item = $conn->query("SELECT o.*,p.name, p.price, p.image_path,b.name as brand, cc.category FROM `order_items` o inner join product_list p on o.product_id = p.id inner join brand_list b on p.brand_id = b.id inner join categories cc on p.category_id = cc.id where o.order_id = '{$id}' order by p.name asc");
                        while($row = $order_item->fetch_assoc()):
                            $total += ($row['quantity'] * $row['price']);
                        ?>
                        <div class="d-flex align-items-center w-100 border cart-item" data-id="<?= $row['id'] ?>">
                            <div class="col-auto flex-grow-1 flex-shrink-1 px-1 py-1">
                                <div class="d-flex align-items-center w-100 ">
                                    <div class="col-auto">
                                        <img src="<?= validate_image($row['image_path']) ?>" alt="Product Image" class="img-thumbnail prod-cart-img">
                                    </div>
                                    <div class="col-auto flex-grow-1 flex-shrink-1">
                                        <a href="./?p=products/view_product&id=<?= $row['product_id'] ?>" class="h4 text-muted" target="_blank">
                                            <p class="text-truncate-1 m-0"><?= $row['name'] ?></p>
                                        </a>
                                        <small><?= $row['brand'] ?></small><br>
                                        <small><?= $row['category'] ?></small><br>
                                        <div class="d-flex align-items-center w-100 mb-1">
                                            <span><?= number_format($row['quantity']) ?></span>
                                            <span class="ml-2">X <?= number_format($row['price'],2) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-right">
                                <h3><b><?= number_format($row['quantity'] * $row['price'],2) ?></b></h3>
                            </div>
                        </div>
                        <?php 
                            endwhile; 
                            endif;
                        ?>
                        <?php if(isset($order_item) && $order_item->num_rows <= 0): ?>
                        <div class="d-flex align-items-center w-100 border justify-content-center">
                            <div class="col-12 flex-grow-1 flex-shrink-1 px-1 py-1">
                                <small class="text-muted">No Data</small>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex align-items-center w-100 border">
                            <div class="col-auto flex-grow-1 flex-shrink-1 px-1 py-1">
                                    <h3 class="text-center">TOTAL</h3>
                            </div>
                            <div class="col-auto text-right">
                                <h3><b><?= number_format($total,2) ?></b></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear-fix my-2"></div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#update_status').click(function(){
            uni_modal("Update Order Status","orders/update_status.php?id=<?= isset($id) ? $id :'' ?>")
        })
        $('#btn-cancel').click(function(){
            _conf("Are you sure to cancel this order?","cancel_order",[])
        })
        $('#delete_order').click(function(){
            _conf("Are you sure to delete this order permanently?","delete_order",[])
        })
    })
    function delete_order(){
        start_loader();
        $.ajax({
            url:_base_url_+'classes/master.php?f=delete_order',
            data:{id : "<?= isset($id) ? $id : '' ?>"},
            method:'POST',
            dataType:'json',
            error:err=>{
                console.error(err)
                alert_toast('An error occurred.','error')
                end_loader()
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.replace('./?page=orders')
                }else if(!!resp.msg){
                    alert_toast(resp.msg,'error')
                }else{
                    alert_toast('An error occurred.','error')
                }
                end_loader();
            }
        })
    }
</script>
