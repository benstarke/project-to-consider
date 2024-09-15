<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>404 Error - Page Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #A0EEE8;
            color: #333;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        h1 {
            margin-bottom: 10px;
            font-size: 4em;
        }
        p {
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        .links {
            margin-top: 20px;
        }
        .icon {
            font-size: 6em;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: darkslategray;
            color: #fff;
            border: none;
            border-radius: 5px;
            margin: 5px;
            text-decoration: none;
            font-size: 1.1em;
            transition: background-color 0.1s ease;
        }
        .btn:hover {
            background-color: slategray;
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="icon">
        Uh oh! <i class="far fa-frown-open"></i>
    </div>
    <br>
    <h1>Page Not Found</h1>
    <p>We couldn't find the page you're looking for.</p>
    <div class="links">
        <a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="btn">Back To Home</a>
    </div>
</div>
</body>
</html>

<!--<script type="text/javascript">-->
<!--    // Redirect to the homepage after a delay (e.g., 3 seconds)-->
<!--    setTimeout(function () {-->
<!--        window.location.href = "/";-->
<!--    }, 3000); // 3000 milliseconds (3 seconds)-->
<!--</script>-->
