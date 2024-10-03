<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RevvRight Motorcycle parts and services management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Google Fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap">
    <style>
        /* Add your custom styles here */
        body {
            font-family: 'Roboto', sans-serif;
        }
        .user-img{
            position: absolute;
            height: 27px;
            width: 27px;
            object-fit: cover;
            left: -7%;
            top: -12%;
        }
        .btn-rounded{
            border-radius: 50px;
        }
    </style>
</head>
<body>

<div class="content py-5 mt-3">
    <div class="container">
        <h3 style="font-weight: bold;">My Service Requests</h3>
        <hr>
        <div class="card card-outline card-dark shadow rounded-0">
            <div class="card-body">
                <div class="container-fluid">
                    <table class="table table-stripped table-bordered">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="25%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-dark text-light" style="font-weight: bold;">
                                <th class="text-center">#</th>
                                <th class="text-center">Date Requested</th>
                                <th class="text-center">Mechanic</th>
                                <th class="text-center">Service Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $mechanic = $conn->query("SELECT * FROM mechanics_list where id in (SELECT mechanic_id FROM `service_requests` where client_id = '{$_settings->userdata('id')}')");
                            $mechanic_arr = array_column($mechanic->fetch_all(MYSQLI_ASSOC),'name','id');
                            $orders = $conn->query("SELECT * FROM `service_requests` where client_id = '{$_settings->userdata('id')}' order by unix_timestamp(date_created) desc ");
                            while($row = $orders->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                    <td><p class="truncate-1 m-0"><?= isset($mechanic_arr[$row['mechanic_id']]) ? $mechanic_arr[$row['mechanic_id']] : "N/A" ?></p></td>
                                    <td class=""><?= $row['service_type'] ?></td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 1): ?>
                                        <span class="badge badge-primary rounded-pill px-3">Confirmed</span>
                                        <?php elseif($row['status'] == 2): ?>
                                            <span class="badge badge-warning rounded-pill px-3">On-progress</span>
                                        <?php elseif($row['status'] == 3): ?>
                                            <span class="badge badge-success rounded-pill px-3">Done</span>
                                        <?php elseif($row['status'] == 4): ?>
                                            <span class="badge badge-danger rounded-pill px-3">Cancelled</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary rounded-pill px-3">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-flat btn-sm btn-default border view_data" type="button" data-id="<?= $row['id'] ?>"><i class="fa fa-eye"></i> View</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function(){
        $('.view_data').click(function(){
            uni_modal("Service Request Details","view_request.php?id="+$(this).attr('data-id'),"mid-large")
        })

        $('.table th, .table td').addClass("align-middle px-2 py-1")
        $('.table').dataTable();
        $('.table').dataTable();
    })
</script>

</body>
</html>
