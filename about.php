<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        /* Custom Button Style */
        .custom-btn {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            transition: background-color 0.3s;
        }
        .custom-btn:hover {
            background-color: #45a049;
        }
        /* Header Style */
        #main-header {
            background-color: #343a40; /* Dark background color */
            color: #fff; /* White text color */
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="bg-dark py-5" id="main-header">
    <div class="container h-100 d-flex align-items-end justify-content-center">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">About Us</h1>
        </div>
    </div>
</header>

<!-- Section -->
<section>
    <div class="container mt-5">
        <div class="card rounded-0">
            <div class="card-body">
                <?php include "about.html"; ?>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS (jQuery required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script to change navbar background on scroll -->
<script>
    $(document).scroll(function() { 
        $('#main-header').removeClass('bg-transparent navbar-dark bg-primary')
        if($(window).scrollTop() === 0) {
           $('#main-header').addClass('navbar-dark bg-transparent')
        } else {
           $('#main-header').addClass('navbar-dark bg-primary')
        }
    });
    $(function(){
        $(document).trigger('scroll')
    })
</script>
</body>
</html>
