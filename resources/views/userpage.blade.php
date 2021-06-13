@extends('layouts.app')

@section('content')

<div class="container h-100">
        @if(session('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
                {{ session('message') }}
            </div>
        @endif
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="row">
                <div class='col-md-12'>
                    <div class="card">
                        <div class="card-header">
                            <span style="font-size:20px;font-weight:600;">Profile</span>
                            <?php $login_user = Auth::user(); ?>
                            @if ($login_user->id == $user->id)
                                <a class="float-right" href="{{ route('changeprofile') }}" data-toggle="tooltip" data-placement="bottom" title="Change"><i class="fas fa-cog" style="font-size:20px; margin:5px 0px 0px 0px;"></i></a>
                            @endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted">{{ $user->number }}</h6>
                            <h4 class="card-title mb-4">{{ $user->name }}</h4>
                            <p>{{ $user->intro }}</p>
                        </div>
                    </div>
                </div>
                <!--
                <div class="col-md-12" style="margin:20px 0px 20px 0px;">
                    <div class="card">
                        <div class="card-header">
                            <span style="font-size:20px;font-weight:600;">Group Affiliation</span>
                            <a class="float-right" href="{{ route('changeprofile') }}" data-toggle="tooltip" data-placement="bottom" title="Join"><i class="fas fa-plus-circle" style="font-size:20px; margin:6px 0px 0px 0px;"></i></a>
                        </div>
                        <div class="card-body">
                            ここにグループの一覧かな...
                        </div>
                    </div>
                </div>
            -->
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <span style="font-size:20px;font-weight:600;">Tweet</span>
                </div>
                <div id="tweetSize" class="card-body" style="height:300px; overflow:scroll;">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($tweets as $tweet)
                    <div class="card" style="margin:0px 0px 20px 0px;">
                        <div class="card-body">
                            <p style="margin:5px 0px;">
                                <a href="{{ route('userpage',['id' => $user->id]) }}">
                                    <span style="font-size:18px; font-weight:bold; margin:0px 15px 0px 0px">{{ $user->name }}</span>
                                </a>
                                <span class="text-muted" style="font-size:13px;">{{ $user->number }}</span>
                                <?php $login_user = Auth::user(); ?>
                                @if ($login_user->id == $user->id)
                                    <i class="far fa-trash-alt" data-toggle="modal" data-target="#deleteModal-{{ $tweet->id }}" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i>
                                @else
                                    <?php $fav = $favs->where('tweet_id',$tweet->id)->where('user_id',$user->id)->first(); ?>
                                    <?php $fav_count = count($favs->where('tweet_id',$tweet->id)->all()); ?>
                                    @if (empty($fav))
                                    <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-form-{{ $tweet->id }}').submit();"><i class="far fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                    @else
                                    <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-del-form-{{ $tweet->id }}').submit();"><i class="fas fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                    @endif
                                    <form id="fav-form-{{ $tweet->id }}" action="{{ route('favtweet') }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                    </form>
                                    <form id="fav-del-form-{{ $tweet->id }}" action="{{ route('favdeltweet') }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                    </form>
                                @endif
                            </p>
                            <!-- ユーザ削除用のモーダルウインドウ -->
                            <div class="modal fade" id="deleteModal-{{ $tweet->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Delete tweet?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ツイートを消しますか？<br>
                                            一度消すともとに戻せなくなります。
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                                                                                        document.getElementById('delete-form-{{ $tweet->id }}').submit();">Delete</button>
                                            <form id="delete-form-{{ $tweet->id }}" action="{{ route('deletetweet') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p style="margin:5px 0px; padding: 0px 5px;">{{ $tweet->tweet }}</p>
                            @if (is_null($tweet->image) == false)
                                <img src="{{ url('images/' . $tweet->user_id . '/' . $tweet->id . '_' . $tweet->image) }}" style="margin:20px 0px; max-width:100%;">
                            @endif
                            <p class="text-muted" style="margin:5px 0px; float:right;">{{ $tweet->updated_at }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
window_load();

window.onresize = window_load;

function window_load(){
    var tweetWindow = document.getElementById("tweetSize");
    tweetWindow.style.height = (window.innerHeight-165) + "px";
}
</script>
@endsection
