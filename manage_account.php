<?php 
// Your PHP code here
?>

<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<body class="bg-dark" style="font-family: 'Roboto', sans-serif;">
   
    <div class="content py-5 mt-3">
        <div class="container">
            <div class="card card-outline card-dark shadow rounded-0">
                <div class="card-header">
                    <h4 class="card-title"><b>Manage Account Information</b></h4>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form id="register-frm" action="" method="post">
                            <input type="hidden" name="id" value="<?= isset($id) ? $id : "" ?>">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" autofocus class="form-control form-control-sm form-control-border" value="<?= isset($firstname) ? $firstname : "" ?>" required>
                                    <small class="form-text text-muted">First Name</small>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="middlename" id="middlename" placeholder="Enter Middle Name (optional)" class="form-control form-control-sm form-control-border" value="<?= isset($middlename) ? $middlename : "" ?>">
                                    <small class="form-text text-muted">Surname</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <select name="gender" id="gender" class="custom-select custom-select-sm form-control-border" required>
                                        <option <?= isset($gender) && $gender == 'Male' ? "selected" : "" ?>>Male</option>
                                        <option <?= isset($gender) && $gender == 'Female' ? "selected" : "" ?>>Female</option>
                                    </select>
                                    <small class="form-text text-muted">Gender</small>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="contact" id="contact" placeholder="Enter Contact #" class="form-control form-control-sm form-control-border" required value="<?= isset($contact) ? $contact : "" ?>">
                                    <small class="form-text text-muted">Tel No.</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <textarea name="address" id="address" rows="3" class="form-control form-control-sm rounded-0" placeholder="Street Number, Building, City, District"><?= isset($address) ? $address : "" ?></textarea>
                                    <small class="form-text text-muted">Address</small>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" placeholder="jsoraya@sample.com" class="form-control form-control-sm form-control-border" required value="<?= isset($email) ? $email : "" ?>">
                                    <small class="form-text text-muted">Email</small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" placeholder="" class="form-control form-control-sm form-control-border">
                                        <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                            <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">New Password</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="password" id="cpassword" placeholder="" class="form-control form-control-sm form-control-border">
                                        <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                            <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Confirm New Password</small>
                                </div>
                                <div class="col-12">
                                    <small class="form-text text-muted"><em>Fill the password outlets above if needed to update your Password.</em></small>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="password" name="oldpassword" id="oldpassword" placeholder="" class="form-control form-control-sm form-control-border" required>
                                        <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                                            <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Current Password</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Update Info.</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php') ?>
</body>
</html>

<script>
    $(function(){
        $('.pass_type').click(function(){
            var type = $(this).attr('data-type')
            if(type == 'password'){
                $(this).attr('data-type','text')
                $(this).closest('.input-group').find('input').attr('type',"text")
                $(this).removeClass("fa-eye-slash")
                $(this).addClass("fa-eye")
            }else{
                $(this).attr('data-type','password')
                $(this).closest('.input-group').find('input').attr('type',"password")
                $(this).removeClass("fa-eye")
                $(this).addClass("fa-eye-slash")
            }
        })
        $('#register-frm').submit(function(e){
            e.preventDefault()
            var _this = $(this)
                    $('.err-msg').remove();
            var el = $('<div>')
                    el.hide()
            if($('#password').val() != $('#cpassword').val()){
                el.addClass('alert alert-danger err-msg').text('Password does not match.');
                _this.prepend(el)
                el.show('slow')
                return false;
            }
            start_loader();
            $.ajax({
                url:_base_url_+"classes/Users.php?f=save_client",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    alert_toast("An error occured",'error');
                    end_loader();
                },
                success:function(resp){
                    if(typeof resp =='object' && resp.status == 'success'){
                        location.reload();
                    }else if(resp.status == 'failed' && !!resp.msg){   
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                    }else{
                        alert_toast("An error occured",'error');
                        end_loader();
                        console.log(resp)
                    }
                    end_loader();
                    $('html, body').scrollTop(0)
                }
            })
        })
    })
</script>
