@extends('layouts.app')

@section('content')

<div class="container">
    <!-- メッセージ用アラート -->
    @if(session('message'))
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                    {{ session('message') }}
                </div>
            </div>
        </div>
    @endif

    @if(session('danger'))
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                    {{ session('danger') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span style="font-size:20px;font-weight:600;">Change Profile</span>
                    <!-- ユーザ削除ボタン -->
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal" style="height:30px;padding:5px 18px;font-size:12px;border-radius:14px;">Delete</button>
                </div>

                <!-- ユーザ削除用のモーダルウインドウ -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete user?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                本当にユーザ " {{$user->name}} " を消しますか？<br>
                                一度消すともとに戻せなくなります。
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                                                                                        document.getElementById('delete-form').submit();">Delete</button>
                                <form id="delete-form" action="{{ route('deleteuser') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('changeprofile') }}">
                        @csrf

                        <!-- ユーザーネームフォーム -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 学籍番号フォーム  -->
                        <div class="form-group row">
                            <label for="number" class="col-md-4 col-form-label text-md-right">{{ __('Student Number') }}</label>
                            <div class="col-md-6">
                                <input id="number" type="text" class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ $user->number }}" required>
                                @if ($errors->has('number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- メールアドレスフォーム -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 自己紹介入力フォーム -->
                        <div class="form-group row">
                            <label for="intro" class="col-md-4 col-form-lavel text-md-right" style="margin:5px 0px 0px 0px;">{{ __('Introduction') }}</label>
                            <div class="col-md-8">
                                <textarea id="intro" class="form-control{{ $errors->has('intro') ? ' is-invalid ' : '' }}" name="intro" rows="5">{{ $user->intro }}</textarea>
                                @if ($errors->has('intro'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('intro') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 自己紹介入力フォーム -->
                        <div class="form-group row">
                            <label for="first_word" class="col-md-4 col-form-lavel text-md-right" style="margin:5px 0px 0px 0px;">{{ __('すぐついボタン1') }}</label>
                            <div class="col-md-8">
                                <textarea id="first_word" class="form-control{{ $errors->has('first_word') ? ' is-invalid ' : '' }}" name="first_word" rows="3">{{ $user->first_word }}</textarea>
                                @if ($errors->has('first_word'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('first_word') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="second_word" class="col-md-4 col-form-lavel text-md-right" style="margin:5px 0px 0px 0px;">{{ __('すぐついボタン2') }}</label>
                            <div class="col-md-8">
                                <textarea id="second_word" class="form-control{{ $errors->has('second_word') ? ' is-invalid ' : '' }}" name="second_word" rows="3">{{ $user->second_word }}</textarea>
                                @if ($errors->has('second_word'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('second_word') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="third_word" class="col-md-4 col-form-lavel text-md-right" style="margin:5px 0px 0px 0px;">{{ __('すぐついボタン3') }}</label>
                            <div class="col-md-8">
                                <textarea id="third_word" class="form-control{{ $errors->has('third_word') ? ' is-invalid ' : '' }}" name="third_word" rows="3">{{ $user->third_word }}</textarea>
                                @if ($errors->has('third_word'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('third_word') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- プロフィール変更ボタン -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection