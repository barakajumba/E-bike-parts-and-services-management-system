<div class="content py-5 mt-3">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-4">Discover Our Brands</h2>
                <hr class="bg-primary opacity-100">
                <div class="search-container">
                    <input type="search" id="search" class="form-control mb-3" placeholder="Search Brands Here" aria-label="Search Brands Here" aria-describedby="basic-addon2">
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 justify-content-center" id="brand_list">
                    <?php 
                    $brands = $conn->query("SELECT * FROM `brand_list` where status = 1 and delete_flag = 0 order by `name`");
                    while($row= $brands->fetch_assoc()):
                     ?>
                    <div class="col mb-4">
                        <div class="card rounded-0 shadow brand-card">
                            <div class="brand-img-holder overflow-hidden position-relative bg-gradient-dark brand-image">
                                <img src="<?= validate_image($row['image_path']) ?>" alt="Brand Image" class="img-fluid"/>
                            </div>
                            <div class="card-body brand-details">
                                <h4 class="card-title text-center"><?= $row['name'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div id="noResult" style="display:none" class="text-center"><b>No Result</b></div>
                <div class="d-flex justify-content-center mt-4">
                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase().trim();
            $('#brand_list .col').each(function(){
                var _text = $(this).find('.card-title').text().toLowerCase().trim();
                if(_text.includes(_search)){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            $('#noResult').toggle($('#brand_list .col:visible').length === 0);
        });

        $('.brand-item').hover(function(){
            $(this).find('.brand-card').addClass('shadow-lg').css('transition', '0.3s');
        }, function(){
            $(this).find('.brand-card').removeClass('shadow-lg').css('transition', '0.3s');
        });

        $('#send_request').click(function(){
            if("<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2 ?>" == 1)
                uni_modal("Fill the Brand Request Form","send_request.php",'mid-large');
            else
                alert_toast(" Please Login First.","warning");
        });
    });
</script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    h2 {
        font-weight: bold;
        font-size: 36px;
        color: #333;
    }

    .brand-card:hover {
        transform: translateY(-5px);
    }

    .brand-image img {
        transition: transform 0.3s ease-in-out;
    }

    .brand-image:hover img {
        transform: scale(1.1);
    }

    .pagination .page-link {
        border-radius: 0 !important;
        transition: background-color 0.3s ease;
    }

    .pagination .page-link:hover {
        background-color: #007bff !important;
        color: #fff !important;
    }
</style>
