<?php if($_settings->chk_flashdata('success')): ?>
<script>
    // Display a success toast using alert_toast function
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

    body {
        font-family: 'Roboto', sans-serif;
    }

    .img-logo {
        width: 3em;
        height: 3em;
        object-fit: scale-down;
        object-position: center center;
    }
    .btn-action {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.5rem;
        background-color: #007bff;
        color: #fff;
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .description p {
        margin-bottom: 0.5rem; /* Adjust as needed */
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Services</h3>
        <div class="card-tools">
            <a href="?page=maintenance/manage_service" class="btn btn-primary btn-action"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="20%">
                    <col width="30%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                        $qry = $conn->query("SELECT * from `service_list` where delete_flag = 0 order by service asc ");
                        while($row = $qry->fetch_assoc()):
                            $row['description'] = strip_tags(html_entity_decode(stripslashes($row['description'])));
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['service'] ?></td>
                            <td class="description">
                                <p class="truncate-3 m-0 lh-1"><small><?php echo $row['description'] ?></small></p>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                 <div class="dropdown">
                                    <button class="btn btn-secondary btn-action dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="?page=maintenance/manage_service&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
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
            _conf("Are you sure to delete this service permanently?","delete_service",[$(this).attr('data-id')])
        });
        $('.table').dataTable();
    });

    function delete_service($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_service",
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
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
