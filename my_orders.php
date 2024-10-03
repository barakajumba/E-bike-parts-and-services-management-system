<!DOCTYPE html>
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

<div class="content py-5 mt-3">
    <div class="container">
        <h3><b>My Orders</b></h3>
        <hr>
        <div class="card card-outline card-dark shadow rounded-0">
            <div class="card-body">
                <div class="container-fluid">
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col width="5%">
                            <col width="20%">
                            <col width="25%">
                            <col width="20%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr class="bg-gradient-dark text-light">
                                <th class="text-center">#</th>
                                <th class="text-center">Date Ordered</th>
                                <th class="text-center">Ref. Code</th>
                                <th class="text-center">Total Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            $orders = $conn->query("SELECT * FROM `order_list` WHERE client_id = '{$_settings->userdata('id')}' ORDER BY unix_timestamp(date_created) DESC");
                            while($row = $orders->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                    <td><?= $row['ref_code'] ?></td>
                                    <td class="text-right"><?= number_format($row['total_amount'], 2) ?></td>
                                    <td class="text-center">
                                        <?php 
                                        $status = [
                                            0 => 'Pending',
                                            1 => 'Packed',
                                            2 => 'For Delivery',
                                            3 => 'On the Way',
                                            4 => 'Delivered',
                                            'Cancelled'
                                        ];
                                        ?>
                                        <span class="badge badge-<?= $row['status'] == 4 ? 'default bg-gradient-teal' : ($row['status'] == 'Cancelled' ? 'danger' : 'secondary') ?> px-3 rounded-pill"><?= $status[$row['status']] ?></span>
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

<script>
    $(function(){
        $('.view_data').click(function(){
            uni_modal("Order Details","view_order.php?id="+$(this).attr('data-id'),"large");
        });

        // Add classes for table cells
        $('.table th, .table td').addClass("align-middle px-2 py-1");

        // Initialize DataTable
        $('.table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true
        });
    });
</script>
