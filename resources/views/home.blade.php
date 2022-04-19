{{--HERE WILL BE API DOCUMENTATION LIKE https://api.elkogroup.com/--}}

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Picser API</title>
</head>
<body>

<div class="container">
    <section>
        <h1>Picser API</h1>
        <h2>Check out the documentation of API here!</h2>
        <h2>Access Security:</h2>
        <ol>
            <li>Firstly you need to create your personal access token. Authorize with login and password provided by
                Administration.
            </li>
            <li>You can create/delete your tokens and also watch statistics of your tokens.</li>
            <li>The token is valid for 1 year.</li>
        </ol>
    </section>

    <button id="authorize">Authorize</button>

    <section>
        <h2 class="header">Images</h2>

        <div class="block method-get">
            <div class="wrapper">
                <span class="method">GET</span>
                <span class="path">/api/images</span>
                <span class="description">Returns array of all images.</span>
            </div>
        </div>

        <div class="block method-get">
            <div class="wrapper">
                <span class="method">GET</span>
                <span class="path">/api/images/{id}</span>
                <span class="description">Returns path to original image. If parameters provided: return cached(10min) modified image.</span>
            </div>
            <h3 class="parameters">Parameters <span>(example: ?w=300&h=300&f=webp&q=85)</span></h3>
            <div class="inner-header">
                <div class="left"><span>Name</span></div>
                <div class="right"><span>Description</span></div>
            </div>
            <div class="inner">
                <div class="left"><span>w (optional)</span></div>
                <div class="right"><span>Resize image <b>width</b> with accept-ratio (if height is not provided, height will be auto)</span>
                </div>
                <div class="left"><span>h (optional)</span></div>
                <div class="right"><span>Resize image <b>height</b> with accept-ratio (if width is not provided, width will be auto)</span>
                </div>
                <div class="left"><span>f (optional)</span></div>
                <div class="right"><span>Change <b>format</b> of image (jpg, png, gif, bmp, ico, webp, data-url)</span>
                </div>
                <div class="left"><span>q (optional)</span></div>
                <div class="right"><span><b>Quality</b> of image in percents (0-100)</span></div>
            </div>
        </div>

        <div class="block method-post">
            <div class="wrapper">
                <span class="method">POST</span>
                <span class="path">/api/images/store</span>
                <span class="description">Store image in service ("key" => "image"), and return uuid of image and path to original image.</span>
            </div>
        </div>
    </section>
</div>
</body>
</html>
