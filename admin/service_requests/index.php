<?php if($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<style>
    /* Custom fonts */
    .card-title {
        font-family: 'Roboto', sans-serif;
    }

    .card-tools .btn {
        font-family: 'Roboto', sans-serif;
    }

    .table th,
    .table td {
        font-family: 'Arial', sans-serif; /* Change 'Arial' to your desired font family */
    }

    .badge {
        font-family: 'Roboto', sans-serif;
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Service Requests</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-primary btn-sm btn-flat"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="35%">
                    <col width="25%">
                    <col width="25%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Client Name</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT s.*,concat(c.lastname,', ', c.firstname,' ',c.middlename) as fullname from service_requests s inner join client_list c on s.client_id = c.id order by unix_timestamp(s.date_created) desc");
                        while($row = $qry->fetch_assoc()):
                            $sids = $conn->query("SELECT meta_value FROM request_meta where request_id = '{$row['id']}' and meta_field = 'service_id'")->fetch_assoc()['meta_value'];
                            $services  = $conn->query("SELECT * FROM service_list where id in ({$sids}) ");
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                            <td><?php echo ucwords($row['fullname']) ?></td>
                            <td>
                                <p class="m-0 truncate-3">
                                <?php 
                                    $s = 0;
                                    while($srow = $services->fetch_assoc()){
                                        $s++;
                                        if($s != 1) echo ", ";
                                        echo $srow['service'];
                                    }
                                ?>  
                                </p>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $status_class = '';
                                    switch($row['status']){
                                        case 1:
                                            $status_class = 'badge-primary';
                                            $status_text = 'Confirmed';
                                            break;
                                        case 2:
                                            $status_class = 'badge-warning';
                                            $status_text = 'On-progress';
                                            break;
                                        case 3:
                                            $status_class = 'badge-success';
                                            $status_text = 'Done';
                                            break;
                                        case 4:
                                            $status_class = 'badge-danger';
                                            $status_text = 'Cancelled';
                                            break;
                                        default:
                                            $status_class = 'badge-secondary';
                                            $status_text = 'Pending';
                                            break;
                                    }
                                ?>
                                <span class="badge <?php echo $status_class; ?> rounded-pill px-3"><?php echo $status_text; ?></span>
                            </td>
                            <td align="center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm btn-flat dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-primary"></span> View</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
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

<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete this service request permanently?","delete_service_request",[$(this).attr('data-id')])
        });
        $('.view_data').click(function(){
            uni_modal("Service Request Details","service_requests/view_request.php?id="+$(this).attr('data-id'),'large')
        });
        $('#create_new').click(function(){
            uni_modal("Service Request Details","service_requests/manage_request.php",'large')
        });
        $('.edit_data').click(function(){
            uni_modal("Service Request Details","service_requests/manage_request.php?id="+$(this).attr('data-id'),'large')
        });
        $('.table').dataTable();
    });

    function delete_service_request($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_request",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error: function(err){
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
