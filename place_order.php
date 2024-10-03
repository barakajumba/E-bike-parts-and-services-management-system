<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <div class="content py-5 mt-3">
        <div class="container">
            <div class="card card-outline card-dark shadow rounded-0">
                <div class="card-header">
                    <h4 class="card-title">Place Order</h4>
                </div>
                <div class="card-body">
                    <form action="" id="place_order_form">
                        <div class="form-group">
                            <label for="delivery_address" class="control-label">Delivery Address</label>
                            <textarea name="delivery_address" id="delivery_address" class="form-control form-control-sm rounded-0" placeholder="Enter your delivery address" rows="4"><?= $_settings->userdata('address') ?></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-flat btn-primary">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            $('#place_order_form').submit(function(e){
                e.preventDefault();
                var _this = $(this);
                $('.err-msg').remove();
                start_loader();
                $.ajax({
                    url: _base_url_+"classes/Master.php?f=place_order",
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    dataType: 'json',
                    error: function(err) {
                        console.log(err);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    },
                    success: function(resp) {
                        if(typeof resp =='object' && resp.status == 'success') {
                            location.replace('./?p=my_orders');
                        } else if(resp.status == 'failed' && !!resp.msg) {
                            var el = $('<div>').addClass("alert alert-danger err-msg").text(resp.msg);
                            _this.prepend(el);
                            el.show('slow');
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader();
                        } else {
                            alert_toast("An error occurred", 'error');
                            end_loader();
                            console.log(resp);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
