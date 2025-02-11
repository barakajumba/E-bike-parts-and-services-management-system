<?php if($_settings->chk_flashdata('success')): ?>
<script>
    // Display a success toast using alert_toast function
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title" style="font-family: 'Montserrat', sans-serif;">List of Mechanics</h3>
        <div class="card-tools">
            <a href="?page=mechanics/manage_mechanic" class="btn btn-primary btn-flat" style="font-family: 'Montserrat', sans-serif;"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped" style="font-family: 'Arial', sans-serif;">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="30%">
                    <col width="25%">
                    <col width="10%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * from `mechanics_list` order by (`name`) asc ");
                        while($row = $qry->fetch_assoc()):
                            foreach($row as $k=> $v){
                                $row[$k] = trim(stripslashes($v));
                            }
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                            <td><?php echo ucwords($row['name']) ?></td>
                            <td>
                                <p class="m-0 lh-1">
                                <?php echo $row['contact'] ?> <br>
                                <?php echo $row['email'] ?>
                                </p>
                            </td>
                            <td class="text-center">
                                <span class="badge <?php echo ($row['status'] == 1) ? 'badge-success' : 'badge-danger'; ?>" style="font-family: 'Arial', sans-serif;"><?php echo ($row['status'] == 1) ? 'Active' : 'Inactive'; ?></span>
                            </td>
                            <td align="center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-flat dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="?page=mechanics/manage_mechanic&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
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
            _conf("Are you sure to delete this mechanic permanently?","delete_mechanic",[$(this).attr('data-id')])
        });
        $('.table').dataTable();
    });

    function delete_mechanic($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_mechanic",
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
