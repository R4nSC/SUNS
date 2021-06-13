<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-relative full-height">
            <div class="mx-auto position-absolute text-center w-80" style="color:white; z-index:10;">
                <p style="font-size:8vw; margin:0;">SUNS</p>
                <p style="font-size:3vw; color:#BDBDBD; margin:0 0 4vw 0;">Shizuoka University Network Service</p>
                @if (Route::has('login'))
                    <p class="links">
                        @auth
                            <?php $user = Auth::user(); ?>
                            <a href="{{ route('userpage',['id' => $user->id]) }}" style="font-size:18px; color:#A9E2F3;">Home</a>
                        @else
                            <a href="{{ route('login') }}" style="font-size:18px; color:#A9E2F3;">Login</a>
                            <a href="{{ route('register') }}" style="font-size:18px; color:#A9E2F3;">Register</a>
                        @endauth
                    </p>
                @endif
            </div>

            <div id="carouselExample" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="background-color:black; text-align:center;">
                        <img class="img-responsive full-height" src="{{ url('images/welcome/smartphone.jpg') }}" alt="First slide" style="opacity:0.3;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>静岡大学専用SNS</h5>
                            <p>学籍番号を登録するだけで簡単に学部学科の投稿が見れる</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item" style="background-color:black; text-align:center;">
                        <img class="img-responsive full-height" src="{{ url('images/welcome/canpas.jpg') }}" alt="First slide" style="opacity:0.3;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>お気に入りのツイート「すこ！」</h5>
                            <p>自分の気に入ったツイートに登録</p>
                        </div>
                    </div>
                    <div class="carousel-item" style="background-color:black; text-align:center;">
                        <img class="img-responsive full-height" src="{{ url('images/welcome/office.jpg') }}" alt="Third slide" style="opacity:0.3;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>全機種に対応したレスポンシブデザイン</h5>
                            <p>パソコンだけでなく、スマートフォンでも不自由なく利用できる</p>
                        </div>
                    </div>
                </div>
                <ol class="carousel-indicators">
                    <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExample" data-slide-to="1"></li>
                    <li data-target="#carouselExample" data-slide-to="2"></li>
                </ol>
                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </body>
</html>
