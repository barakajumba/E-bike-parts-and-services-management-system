
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table th,
        .table td {
            padding: 12px;
            text-align: center;
        }
        .table th {
            background-color: #343a40;
            color: #ffffff;
        }
        .table td {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
        .badge-primary {
            background-color: #007bff;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-warning {
            background-color: #ffc107;
        }
        .badge-default {
            background-color: #20c997;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .btn-view {
            background-color: transparent;
            border: none;
            color: #007bff;
            cursor: pointer;
            transition: color 0.3s;
        }
        .btn-view:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
    Toast.fire({
        icon: 'success',
        title: '<?php echo $_settings->flashdata('success') ?>'
    });
</script>
<?php endif; ?>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Products</h3>
        <div class="card-tools">
            <a href="?page=products/manage_product" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Date Created</th>
                        <th class="text-center">Brand</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT p.*,b.name as brand from `product_list` p inner join brand_list b on p.brand_id = b.id where p.delete_flag = 0 order by (p.`name`) asc ");
                    while($row = $qry->fetch_assoc()):
                        foreach($row as $k=> $v){
                            $row[$k] = trim(stripslashes($v));
                        }
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                            <td><?php echo ucwords($row['brand']) ?></td>
                            <td><?php echo ucwords($row['name']) ?></td>
                            <td class="text-right"><?= number_format($row['price'],2) ?></td>
                            <td class="text-center">
                                <span class="badge <?php echo $row['status'] == 1 ? 'bg-success' : 'bg-danger' ?> px-3"><?php echo $row['status'] == 1 ? 'Active' : 'Inactive' ?></span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="?page=products/view_product&id=<?php echo $row['id'] ?>"><i class="fas fa-eye mr-2"></i> View</a>
                                        <a class="dropdown-item" href="?page=products/manage_product&id=<?php echo $row['id'] ?>"><i class="fas fa-edit mr-2"></i> Edit</a>
                                        <a class="dropdown-item delete_data" href="#" data-id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt mr-2"></i> Delete</a>
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
            _conf("Are you sure to delete this product permanently?","delete_product",[$(this).attr('data-id')])
        });
        $('.table').DataTable();
    });
    
    function delete_product($id){
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_product",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: function(err){
                console.log(err);
                Toast.fire({
                    icon: 'error',
                    title: 'An error occurred.'
                });
                end_loader();
            },
            success: function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    location.reload();
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred.'
                    });
                    end_loader();
                }
            }
        });
    }
</script>
