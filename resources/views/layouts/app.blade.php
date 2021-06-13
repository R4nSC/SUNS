<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('SUNS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('SUNS') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <!-- <span class="text-warning">{{ __('MyPage') }}</span> -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <?php $now_login_user = Auth::user(); ?>
                            <li class="nav-item" style="margin:3px 7px;">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tweetModal" data-tooltip="tooltip" data-placement="bottom" title="{{ $now_login_user->first_word }}" onclick="tweetButton('<?php echo $now_login_user->first_word; ?>');" style="padding:3px 10px;">1</button>
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tweetModal" data-tooltip="tooltip" data-placement="bottom" title="{{ $now_login_user->second_word }}" onclick="tweetButton('<?php echo $now_login_user->second_word; ?>');" style="padding:3px 10px;">2</button>
                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tweetModal" data-tooltip="tooltip" data-placement="bottom" title="{{ $now_login_user->third_word }}" onclick="tweetButton('<?php echo $now_login_user->third_word; ?>');" style="padding:3px 10px;">3</button>
                                </div>
                                <div class="modal fade" id="tweetButtonModal1" tabindex="-1" role="dialog" aria-labelledby="tweetButtonModal1Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p>{{$now_login_user->first_word}}をつぶやきますか。</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" onclick="tweetButton('<?php echo $now_login_user->first_word; ?>');">Tweet</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="tweetButtonModal2" tabindex="-1" role="dialog" aria-labelledby="tweetButtonModal2Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p>{{$now_login_user->second_word}}をつぶやきますか。</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" onclick="tweetButton('<?php echo $now_login_user->second_word; ?>');">Tweet</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="tweetButtonModal3" tabindex="-1" role="dialog" aria-labelledby="tweetButtonModal3Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <p>{{$now_login_user->third_word}}をつぶやきますか。</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success" onclick="tweetButton('<?php echo $now_login_user->third_word; ?>');">Tweet</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item" style="margin:0px 7px;">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#tweetModal">{{ __('Tweet') }}</a>
                                <!--  ツイート用のモーダルウインドウ -->
                                <div class="modal fade" id="tweetModal" tabindex="-1" role="dialog" aria-labelledby="tweetModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="tweet-form" action="{{ route('tweet') }}" method="POST" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tweetModalLabel">Tweet</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @csrf

                                                    <textarea id="tweet" class="form-control{{ $errors->has('tweet') ? ' is-invalid ' : '' }}" name="tweet" rows="3" placeholder="less than 100 characters" maxlength="100"></textarea>

                                                    <div class="upload_file"></div>

                                                </div>
                                                <div class="modal-footer">
                                                    <label for="image_file">
                                                        <i class="far fa-image" style="margin:10px 15px 0px 0px; font-size:28px; color:#2E9AFE; cursor:pointer;"></i>
                                                        <input type="file" class="form-control{{ $errors->has('image_file') ? ' is-invalid ' : '' }}" name="image_file" id="image_file" accept="image/*"  enctype="multipart/form-data" style="display:none;">
                                                    </label>

                                                    <button type="button" class="btn btn-success" onclick="event.preventDefault();
                                                                                            document.getElementById('tweet-form').submit();">Tweet</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown" style="margin:0px 7px;">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Home') }}
                                    </a>

                                    <?php $user = Auth::user(); ?>
                                    <a class="dropdown-item" href="{{ route('userpage',['id' => $user->id]) }}">
                                        {{ __('MyPage') }}
                                    </a>

                                    <div role="separator" class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function() {
    $('body').tooltip({
        selector: "[data-tooltip=tooltip]",
        container: "body"
    });
});

$(document).ready(function(){
    $('[data-tooltip="tooltip"]').tooltip(); 
});

$(function(){
$('form').on('change','input[type="file"]',function(e){
    var file = e.target.files[0],
        reader = new FileReader(),
        $preview = $(".upload_file");
        t = this;

        if(file.type.indexOf("image") < 0){
            return false;
        }

        reader.onload = (function(file){
            return function(e){
                $preview.empty();

                $preview.append($('<i>').attr({
                    class: 'far fa-times-circle',
                    style: 'font-size:20px; float:right; margin:10px 0px 0px 0px;',
                    onclick: 'deleteImage()'
                }));

                $preview.append($('<img>').attr({
                    src: e.target.result,
                    style: "max-width:100%; margin:5px 0px 10px 0px; cursor:pointer;",
                    class: "preview",
                    title: file.name
                }));

            };
        })(file);

        reader.readAsDataURL(file);
    });
});

function deleteImage(){
    $(function(){
        $(".upload_file").empty();
    });
}

function tweetButton(word){
    event.preventDefault();
    document.getElementById('tweet').value = word;
}
</script>
</html>
