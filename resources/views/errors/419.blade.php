<!DOCTYPE html>
<html>
<head>
    <title>Under Maintenance</title>
    <style>
        body { text-align: center; padding: 150px; }
        h1 { font-size: 50px; }
        body { font: 20px Helvetica, sans-serif; color: #333; }
        article { display: block; text-align: left; width: 650px; margin: 0 auto; }
        a { color: #dc8100; text-decoration: none; }
        a:hover { color: #333; text-decoration: none; }
    </style>
</head>
<body>
<article>
    <img src="{{ url('/images/doh_csmc.png') }}" alt="">
    <h1>Opps! Something went wrong -_-</h1>
    <div>
        <p>Sorry for the inconvenience! Please visit <a href="{{ url('/login') }}">login page</a> again!</p>
        <p>&mdash; System Administrator</p>
    </div>
</article>
</body>
</html>
