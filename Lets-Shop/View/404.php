<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Error - Page Not Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="container text-center">
    <h1 class="display-1">404</h1>
    <p class="lead">Oops! The page you are looking for could not be found.</p>
    <a href="<?= route('shop') ?>" class="btn btn-primary">Go to Homepage</a>
</div>
</body>
</html>