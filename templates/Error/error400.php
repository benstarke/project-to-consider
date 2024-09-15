<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */

$this->layout = 'default';
?>
    <!-- Vendor CSS Files -->
    <?= $this->Html->css('/vendor/bootstrap/css/bootstrap.min.css') ?>
    <?= $this->Html->css('/vendor/bootstrap-icons/bootstrap-icons.css') ?>
    <!-- <?= $this->Html->css('/vendor/aos/aos.css') ?> -->
    <?= $this->Html->css('/vendor/glightbox/css/glightbox.min.css') ?>
    <?= $this->Html->css('/vendor/swiper/swiper-bundle.min.css') ?>


    <?= $this->Html->css('variables.css') ?>

    <!-- Template Main CSS File -->
    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->css('styles.css') ?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Oops! Page Not Found</h1>
    <p>We couldn't find the page you're looking for.</p>
    <a href="javascript:history.back()">Go Back</a>
</div>
</body>
</html>


<!--<html>-->
<!--<head>-->
<!--     <script type="text/javascript">-->
<!--        // Redirect to the homepage after a delay (e.g., 3 seconds)-->
<!--        setTimeout(function () {-->
<!--            window.location.href = "/";-->
<!--        }, 3000); // 3000 milliseconds (3 seconds)-->
<!--    </script> -->
<!--</head>-->
<!--<body>-->
<!--<section class="text-center mx-5" style ="height:50vw">-->
<!--    <h1>404 Not Found</h1>-->
<!--    <p>The page you requested was not found.</p>-->
<!--</section>-->
<!--</body>-->
<!--</html>-->
