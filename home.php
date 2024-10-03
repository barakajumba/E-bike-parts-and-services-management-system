<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RevRight Online Motorcycle Parts and Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Header */
        #main-header {
            background-color: #343a40;
            padding: 30px 0;
        }

        #main-header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Social Media Icons */
        .social-icons a {
            color: #fff;
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .social-icons a:hover {
            color: #ffc107; /* Change the color on hover */
        }

        /* Section */
        .product-item {
            color: #000;
            text-decoration: none;
        }

        .product-item:hover {
            color: #007bff;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Blinking Green Alert */
        .blink {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        /* Dancing Cartoon */
        .dancing-cartoon {
            width: 100px;
            height: auto;
            animation: dance 2s infinite alternate;
        }

        @keyframes dance {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="bg-dark py-5" id="main-header">
        <div class="container h-100 d-flex flex-column align-items-center justify-content-center">
            <h1 class="display-4 fw-bolder blink"><?php echo $_settings->info('name') ?></h1>
            <div class="col-auto mt-4">
                <a class="btn btn-primary btn-lg rounded-pill" href="./?p=products">Purchase Now</a>
            </div>
            <!-- Social Media Icons -->
            <div class="mt-3 social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a> <!-- YouTube Icon -->
                <!-- Add more social media icons as needed -->
            </div>
        </div>
    </header>

    <!-- Running Timer -->
    <div class="container text-center mt-5">
        <h2>Activity Timer</h2>
        <div id="timer">00:00:00</div>
    </div>

 
    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-xl-4">
                <?php
                $products = $conn->query("SELECT p.*,b.name as brand, c.category FROM product_list p inner join brand_list b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.delete_flag = 0 and p.status = 1 order by RAND() limit 4");
                while ($row = $products->fetch_assoc()) :
                ?>
                    <a class="col px-1 py-2 product-item" href="./?p=products/view_product&id=<?= $row['id'] ?>">
                        <div class="card">
                            <div class="product-img-holder overflow-hidden position-relative">
                                <img src="<?= validate_image($row['image_path']) ?>" alt="Product Image" class="img-top" />
                                <span class="position-absolute price-tag rounded-pill bg-gradient-primary text-light px-3">
                                    <i class="fa fa-tags"></i> <b><?= number_format($row['price'], 2) ?></b>
                                </span>
                            </div>
                            <div class="card-body border-top">
                                <h4 class="card-title"><b><?= $row['name'] ?></b></h4>
                                <p class="card-text"><?= strip_tags(html_entity_decode($row['description'])) ?></p>
                                <small class="text-muted"><?= $row['brand'] ?></small><br>
                                <small class="text-muted"><?= $row['category'] ?></small>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Bootstrap Bundle with Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <!-- Timer Script -->
    <script>
        function updateTimer() {
            var timerElement = document.getElementById('timer');
            var startTime = new Date();

            setInterval(function() {
                var currentTime = new Date();
                var elapsedTime = currentTime - startTime;

                var hours = Math.floor(elapsedTime / (1000 * 60 * 60));
                var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

                hours = (hours < 10) ? '0' + hours : hours;
                minutes = (minutes < 10) ? '0' + minutes : minutes;
                seconds = (seconds < 10) ? '0' + seconds : seconds;

                timerElement.textContent = hours + ':' + minutes + ':' + seconds;
            }, 1000);
        }

        window.onload = function() {
            updateTimer();
        };
    </script>
</body>

</html>
