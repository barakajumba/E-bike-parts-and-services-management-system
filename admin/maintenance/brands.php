<?php if($_settings->chk_flashdata('success')): ?>
<script>
    // Display a success toast using alert_toast function
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>

<!-- Add link to Roboto font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

<style>
    /* Font Customization */
    body {
        font-family: 'Roboto', sans-serif;
    }

    /* Button Customization */
    .btn-action {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.5rem;
        background-color: #007bff; /* Button background color */
        color: #fff; /* Button text color */
        border: 1px solid transparent; /* Button border */
        transition: all 0.3s ease; /* Button transition */
    }

    .btn-action:hover {
        background-color: #0056b3; /* Hover background color */
        border-color: #0056b3; /* Hover border color */
    }
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Brands</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-primary btn-action"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-striped">
                <colgroup>
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="15%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Logo</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query("SELECT * from `brand_list` where delete_flag= 0 order by `name` asc ");
                        while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                            <td class="text-center">
                                <img src="<?= validate_image($row['image_path']) ?>" alt="Brand Logo - <?= $row['name'] ?>" class="img-logo img-thumbnail">
                            </td>
                            <td><?php echo $row['name'] ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 1): ?>
                                    <span class="badge badge-success mx-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger mx-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-action dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
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
        $('#create_new').click(function(){
            uni_modal("Add New Brand", "maintenance/manage_brand.php", "mid-large");
        });

        $('.edit_data').click(function(){
            uni_modal("Add New Brand", "maintenance/manage_brand.php?id=" + $(this).attr('data-id'), "mid-large");
        });

        $('.delete_data').click(function(){
            _conf("Are you sure to delete this brand permanently?", "delete_brand", [$(this).attr('data-id')]);
        });

        $('.table th, .table td').addClass("align-middle px-2 py-1");
        $('.table').dataTable();
    });

    function delete_brand(id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_brand",
            method: "POST",
            data: {id: id},
            dataType: "json",
            error: function(err){
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp){
                if(resp.status == 'success'){
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
