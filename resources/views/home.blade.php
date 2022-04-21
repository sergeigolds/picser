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
        </ol>
    </section>

    @auth
        <h3>Your tokens:</h3>
        @if(!$user_tokens->isEmpty())
            <table id="tokens">
                <thead>
                <tr>
                    <th>Token name</th>
                    <th>Token key</th>
                    <th>Domain name</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $user_tokens as $token)
                    <tr>
                        <td>{{ $token->token_name  }}</td>
                        <td>{{ $token->token_key  }}</td>
                        <td>{{ $token->token_domain  }}</td>
                        <td>{{ \Carbon\Carbon::parse($token->created_at)->diffForHumans() }}</td>
                        <td>
                            <form action="{{ '/tokens/delete/' . $token->token_id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>


                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>You don't have any tokens.</p>
        @endif

        <form action="{{ route('token.create')  }}" method="post" id="user_tokens">
            @csrf
            <div class="inner">
                <input type="text" name="token_name" placeholder="Token name">
                @error('token_name')
                <div class="error-message">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="inner">
                <input type="text" name="token_domain" placeholder="Domain name">
                @error('token_domain')
                <div class="error-message">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" id="authorize">Create new token</button>
        </form>


    @endauth

    @guest
        <div class="guest">
            <h3>To see your tokens you need to authorize</h3>
            <form action="{{ route('login') }}" method="post">
                @csrf
                @if (session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif
                <input name="email" type="text" placeholder="Email">
                @error('email')
                <div class="error-message">
                    {{ $message }}
                </div>
                @enderror
                <input name="password" type="password" placeholder="Password">
                @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
                @enderror
                <button type="submit" id="authorize">Authorize</button>
            </form>
        </div>
    @endguest


    <section>
        <h2 class="header">Images</h2>

        <div class="block method-get">
            <div class="wrapper">
                <span class="method">GET</span>
                <span class="path">/api/images/{id}</span>
                <span class="description">Returns url of original image. If parameters provided: return cached(10min) modified image.</span>
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
                <span class="description">Store image in service ("key" => "image"), and return uuid of image and url of original image.</span>
            </div>
            <h3 class="parameters">Parameters <span>(example: ?f=webp)</span></h3>
            <div class="inner-header">
                <div class="left"><span>Name</span></div>
                <div class="right"><span>Description</span></div>
            </div>
            <div class="inner">
                <div class="left"><span>f (optional)</span></div>
                <div class="right"><span>Change <b>format</b> of image (jpg, png, gif, bmp, ico, webp, data-url)</span>
                </div>
            </div>
        </div>

        <div class="block method-put">
            <div class="wrapper">
                <span class="method">PUT</span>
                <span class="path">/api/images/{id}/edit</span>
                <span class="description">If parameters provided edit original image.</span>
            </div>
            <h3 class="parameters">Parameters <span>(example: ?f=webp)</span></h3>
            <div class="inner-header">
                <div class="left"><span>Name</span></div>
                <div class="right"><span>Description</span></div>
            </div>
            <div class="inner">
                <div class="left"><span>f (required)</span></div>
                <div class="right"><span>Change <b>format</b> of image (jpg, png, gif, bmp, ico, webp, data-url)</span>
                </div>
            </div>
        </div>

        <div class="block method-delete">
            <div class="wrapper">
                <span class="method">DELETE</span>
                <span class="path">/api/images/{id}/delete</span>
                <span class="description">Delete image from database and storage.</span>
            </div>
        </div>
    </section>
</div>
</body>
</html>
