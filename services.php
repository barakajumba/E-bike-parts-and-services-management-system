
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #343a40;
            color: #fff;
            padding: 80px 0;
        }
        .search-container {
            text-align: center;
            margin-bottom: 40px;
        }
        #search {
            width: 300px;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid #ced4da;
        }
        .service-item {
            margin-bottom: 20px;
        }
        .service-item h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
        .service-item p {
            color: #6c757d;
        }
        #noResult {
            display: none;
            color: red;
            margin-top: 20px;
        }
    </style>
<body>


<header class="bg-dark py-5" id="main-header">
      <div class="container h-100 d-flex align-items-end justify-content-center w-100">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 fw-bold"><?php echo $_settings->info('name') ?></h1>
                <p class="lead mb-4">Rest assured, we'll manage your bike</p>
                <button class="btn btn-primary btn-lg" id="send_request" type="button">Submit Service Request</button>
            </div>
        </div>
    </div>
</header>

<section>
    <div class="container">
        <div class="search-container">
            <input type="search" id="search" class="form-control" placeholder="Search Service Here" aria-label="Search Service Here">
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4" id="service_list">
            <?php 
            $services = $conn->query("SELECT * FROM `service_list` where status = 1 and delete_flag = 0 order by `service`");
            while($row= $services->fetch_assoc()):
                $row['description'] = strip_tags(html_entity_decode(stripslashes($row['description'])));
            ?>
            <div class="col service-item">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $row['service'] ?></h3>
                        <p class="card-text"><?php echo $row['description'] ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div id="noResult"><b>No Result</b></div>
    </div>
</section>

<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase().trim()
            $('#service_list .service-item').each(function(){
                var _text = $(this).text().toLowerCase().trim()
                if((_text).includes(_search) == true){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            })
            if( $('#service_list .service-item:visible').length > 0){
                $('#noResult').hide();
            }else{
                $('#noResult').show();
            }
        })

        $('#send_request').click(function(){
            if("<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2 ?>" == 1)
            uni_modal("Fill the Service Request Form","send_request.php",'mid-large');
            else
            alert_toast(" Please Login First.","warning");
        })
    });
</script>

</body>
</html>
