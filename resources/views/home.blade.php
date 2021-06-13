@extends('layouts.app')

@section('content')

<div class="container h-100" id="windowArea">
    @if(session('message'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="true">×</span></button>
        {{ session('message') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-uni-tab" data-toggle="pill" href="#v-pills-uni" role="tab" aria-controls="v-pills-uni" aria-selected="true">
                    Shizuoka University
                </a>
                <a class="nav-link" id="v-pills-fac-tab" data-toggle="pill" href="#v-pills-fac" role="tab" aria-controls="v-pills-fac" aria-selected="false">
                    <?php $fac_num = intval($user->number/10000000) ?>
                    @if ($fac_num == 7)
                        Information Faculty
                    @elseif ($fac_num == 5)
                        Engineering Faculty
                    @else
                        ???
                    @endif
                </a>
                <a class="nav-link" id="v-pills-dep-tab" data-toggle="pill" href="#v-pills-dep" role="tab" aria-controls="v-pills-dep" aria-selected="false">
                    <?php $dep_num = intval($user->number/1000)%(intval($user->number/10000)*10) ?>
                    @if ($fac_num == 7)
                        @if ($dep_num == 0)
                            Computer Science
                        @elseif ($dep_num == 1)
                            Behavior Information
                        @elseif ($dep_num == 2)
                            Information Society
                        @endif
                    @elseif ($fac_num == 5)
                        @if ($dep_num == 0)
                            Mechanical Engineering
                        @elseif ($dep_num == 1)
                            Electrical and Electronic Engineering
                        @elseif ($dep_num == 4)
                            Electronic Materials Science
                        @elseif ($dep_num == 5)
                            Chemical Bioengineering
                        @elseif ($dep_num == 6)
                            Mathematical Systems Engineering
                        @endif
                    @else 
                        ???
                    @endif
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-uni" role="tabpanel" aria-labelledby="v-pills-uni-tab">
                    @foreach($tweets as $tweet_uni)
                    <?php $uni_id = $tweet_uni->user_id; $unitweet_user = $users->where('id',$uni_id)->first(); ?>
                    <?php $fav = $favs->where('tweet_id',$tweet_uni->id)->where('user_id',$user->id)->first(); ?>
                    <?php $fav_count = count($favs->where('tweet_id',$tweet_uni->id)->all()); ?>
                    <div class="card" data-toggle="modal" data-target="#tweetModal-{{ $tweet_uni->id }}" style="margin:0px 0px 20px 0px;">
                        <div class="card-body">
                            <p style="margin:5px 0px;">
                                <a href="{{ route('userpage',['id' => $tweet_uni->user_id]) }}">
                                    <span style="font-size:18px; font-weight:bold; margin:0px 15px 0px 0px">{{ $unitweet_user->name }}</span>
                                </a>
                                <span class="text-muted" style="font-size:13px;">{{ $unitweet_user->number }}</span>
                                @if ($uni_id == $user->id)
                                    <i class="far fa-trash-alt" data-toggle="modal" data-target="#deleteModal-{{ $tweet_uni->id }}" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer; z-index:100;"></i>
                                    <!-- ユーザ削除用のモーダルウインドウ -->
                                @else
                                    @if (empty($fav))
                                        <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-form-{{ $tweet_uni->id }}').submit();"><i class="far fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                        <form id="fav-form-{{ $tweet_uni->id }}" action="{{ route('favtweet') }}" method="POST" style="display:none;">
                                            @csrf
                                            <input type="hidden" name="tweet_id" value="{{ $tweet_uni->id }}">
                                        </form>
                                    @else
                                        <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-del-form-{{ $tweet_uni->id }}').submit();"><i class="fas fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                        <form id="fav-del-form-{{ $tweet_uni->id }}" action="{{ route('favdeltweet') }}" method="POST" style="display:none;">
                                            @csrf
                                            <input type="hidden" name="tweet_id" value="{{ $tweet_uni->id }}">
                                        </form>
                                    @endif
                                @endif
                            </p>
                            <p style="margin:5px 0px; padding: 0px 5px;">{{ $tweet_uni->tweet }}</p>
                            <p class="text-muted" style="margin:5px 0px; float:right;">{{ $tweet_uni->updated_at }}</p>
                        </div>
                    </div>
                    <div class="modal fade" id="tweetModal-{{ $tweet_uni->id }}" tabindex="-1" role="dialog" aria-labelledby="tweetModalLabel" aria-hidden="true">
                        <div class="modal-dialog shadow-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body" style="padding:20px;">
                                    <p>
                                        <a href="{{ route('userpage',['id' => $tweet_uni->user_id]) }}">
                                            <span style="font-size:18px; font-weight:bold; margin:0px 15px 0px 0px">{{ $unitweet_user->name }}</span>
                                        </a>
                                        <span class="text-muted" style="font-size:13px;">{{ $unitweet_user->number }}</span>
                                    </p>
                                    <p style="margin:5px 0px; padding: 0px 5px;">{{ $tweet_uni->tweet }}</p>
                                    @if (is_null($tweet_uni->image) == false)
                                        <img src="{{ url('images/' . $tweet_uni->user_id . '/' . $tweet_uni->id . '_' . $tweet_uni->image) }}" style="margin:20px 0px; max-width:100%;">
                                    @endif
                                    <p class="text-muted" style="margin:5px 0px; float:right;">{{ $tweet_uni->updated_at }}</p>
                                </div>
                                <div class="modal-footer" style="margin: 10px 10px 5px;">
                                    <div class="w-100">
                                        @if ($fav_count != 0)
                                            <div class="float-left" data-toggle="modal" data-target="#favModal-{{ $tweet_uni->id }}">{{ $fav_count }}人のすこ！</div>
                                        @endif
                                        @if ($uni_id == $user->id)
                                            <i class="far fa-trash-alt" data-toggle="modal" data-target="#deleteModal-{{ $tweet_uni->id }}" style="margin: 5px 0px 0px 0px; float:right; cursor:pointer;"></i>
                                        @else
                                            @if (empty($fav))
                                                <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-form-{{ $tweet_uni->id }}').submit();"><i class="far fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 5px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                            @else
                                                <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-del-form-{{ $tweet_uni->id }}').submit();"><i class="fas fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 5px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal-{{ $tweet_uni->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog shadow-lg" role="document">
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
                                                        document.getElementById('delete-form-{{ $tweet_uni->id }}').submit();">Delete</button>
                                    <form id="delete-form-{{ $tweet_uni->id }}" action="{{ route('deletetweet') }}" method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet_uni->id }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="favModal-{{ $tweet_uni->id }}" tabindex="-1" role="dialog" aria-labelledby="favModalLabel"aria-hidden="true">
                        <div class="modal-dialog modal-sm shadow-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="favModalLabel" style="margin:0 auto;">{{ $fav_count }}人のすこ！</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="padding:0">
                                    <?php $fav_users = $favs->where('tweet_id',$tweet_uni->id)->all(); ?>
                                    <ul class="list-group">
                                    @foreach ($fav_users as $fav_user)
                                        <?php $favuser_info = $users->where('id',$fav_user->user_id)->first(); ?>
                                        <li class="list-group-item" style="border-radius:0">
                                            <p style="margin:5px 0px;">
                                                <a href="{{ route('userpage',['id' => $favuser_info->id]) }}">
                                                    <span style="font-size:18px; font-weight:bold; margin:0px 15px 0px 0px">{{ $favuser_info->name }}</span>
                                                </a>
                                                <span class="text-muted" style="font-size:13px;">{{ $favuser_info->number }}</span>
                                            </p>
                                            <p>{{ $favuser_info->intro }}</p>
                                        </li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="v-pills-fac" role="tabpanel" aria-labelledby="v-pills-fac-tab">
                    @foreach($tweets as $tweet_fac)
                    <?php $fac_id = $tweet_fac->user_id; $factweet_user = $users->where('id',$fac_id)->first(); ?>
                    <?php $tweet_fac_num = intval($factweet_user->number/10000000); ?>
                    @if ($fac_num == $tweet_fac_num)
                    <div class="card" style="margin:0px 0px 20px 0px;">
                        <div class="card-body">
                            <p style="margin:5px 0px;">
                                <a href="{{ route('userpage',['id' => $tweet_uni->user_id]) }}">
                                    <span style="font-size:18px; font-weight:bold; margin:0px 15px 0px 0px">{{ $factweet_user->name }}</span>
                                </a>
                                <span class="text-muted" style="font-size:13px;">{{ $factweet_user->number }}</span>
                                @if ($fac_id == $user->id)
                                    <i class="far fa-trash-alt" data-toggle="modal" data-target="#deleteModal-{{ $tweet_fac->id }}" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i>
                                    <!-- ユーザ削除用のモーダルウインドウ -->
                                    <div class="modal fade" id="deleteModal-{{ $tweet_fac->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                            document.getElementById('delete-form-{{ $tweet_fac->id }}').submit();">Delete</button>
                                                    <form id="delete-form-{{ $tweet_fac->id }}" action="{{ route('deletetweet') }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="tweet_id" value="{{ $tweet_fac->id }}">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <?php $fav = $favs->where('tweet_id',$tweet_fac->id)->where('user_id',$user->id)->first(); ?>
                                    <?php $fav_count = count($favs->where('tweet_id',$tweet_fac->id)->all()); ?>
                                    @if (empty($fav))
                                    <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-form-{{ $tweet_fac->id }}').submit();"><i class="far fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                    <form id="fav-form-{{ $tweet_fac->id }}" action="{{ route('favtweet') }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet_fac->id }}">
                                    </form>
                                    @else
                                    <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-del-form-{{ $tweet_fac->id }}').submit();"><i class="fas fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                    <form id="fav-del-form-{{ $tweet_fac->id }}" action="{{ route('favdeltweet') }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet_fac->id }}">
                                    </form>
                                    @endif
                                @endif
                            </p>
                            <p style="margin:5px 0px; padding: 0px 5px;">{{ $tweet_fac->tweet }}</p>
                            <p class="text-muted" style="margin:5px 0px; float:right;">{{ $tweet_fac->updated_at }}</p>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="v-pills-dep" role="tabpanel" aria-labelledby="v-pills-dep-tab">
                    @foreach($tweets as $tweet_dep)
                    <?php $dep_id = $tweet_dep->user_id; $deptweet_user = $users->where('id',$dep_id)->first(); ?>
                    <?php $tweet_dep_num = intval($deptweet_user->number/1000); ?>
                    <?php $d_num = intval($user->number/1000); ?>
                    @if ($d_num == $tweet_dep_num)
                    <div class="card" style="margin:0px 0px 20px 0px;">
                        <div class="card-body">
                            <p style="margin:5px 0px;">
                                <a href="{{ route('userpage',['id' => $tweet_uni->user_id]) }}">
                                    <span style="font-size:18px; font-weight:bold; margin:0px 15px 0px 0px">{{ $deptweet_user->name }}</span>
                                </a>
                                <span class="text-muted" style="font-size:13px;">{{ $deptweet_user->number }}</span>
                                @if ($dep_id == $user->id)
                                    <i class="far fa-trash-alt" data-toggle="modal" data-target="#deleteModal-{{ $tweet_dep->id }}" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i>
                                    <!-- ユーザ削除用のモーダルウインドウ -->
                                    <div class="modal fade" id="deleteModal-{{ $tweet_dep->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                                            document.getElementById('delete-form-{{ $tweet_dep->id }}').submit();">Delete</button>
                                                    <form id="delete-form-{{ $tweet_dep->id }}" action="{{ route('deletetweet') }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="tweet_id" value="{{ $tweet_dep->id }}">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <?php $fav = $favs->where('tweet_id',$tweet_dep->id)->where('user_id',$user->id)->first(); ?>
                                    <?php $fav_count = count($favs->where('tweet_id',$tweet_dep->id)->all()); ?>
                                    @if (empty($fav))
                                    <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-form-{{ $tweet_dep->id }}').submit();"><i class="far fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                    <form id="fav-form-{{ $tweet_dep->id }}" action="{{ route('favtweet') }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet_dep->id }}">
                                    </form>
                                    @else
                                    <a class="float-right" onclick="event.preventDefault();document.getElementById('fav-del-form-{{ $tweet_dep->id }}').submit();"><i class="fas fa-star" data-toggle="tooltip" data-placement="bottom" title="{{ $fav_count }}すこ" style="margin: 10px 0px 0px 0px; float:right; cursor:pointer;"></i></a>
                                    <form id="fav-del-form-{{ $tweet_dep->id }}" action="{{ route('favdeltweet') }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="tweet_id" value="{{ $tweet_dep->id }}">
                                    </form>
                                    @endif
                                @endif
                            </p>
                            <p style="margin:5px 0px; padding: 0px 5px;">{{ $tweet_dep->tweet }}</p>
                            <p class="text-muted" style="margin:5px 0px; float:right;">{{ $tweet_dep->updated_at }}</p>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

$(document).ready(function() {

    $('.modal').on('hidden.bs.modal', function(event) {
        $(this).removeClass( 'fv-modal-stack' );
        $('body').data( 'fv_open_modals', $('body').data( 'fv_open_modals' ) - 1 );
    });

    $('.modal').on('shown.bs.modal', function (event) {
        // keep track of the number of open modals
        if ( typeof( $('body').data( 'fv_open_modals' ) ) == 'undefined' ) {
            $('body').data( 'fv_open_modals', 0 );
        }

        // if the z-index of this modal has been set, ignore.
        if ($(this).hasClass('fv-modal-stack')) {
            return;
        }

        $(this).addClass('fv-modal-stack');
        $('body').data('fv_open_modals', $('body').data('fv_open_modals' ) + 1 );
        $(this).css('z-index', 1040 + (10 * $('body').data('fv_open_modals' )));
        $('.modal-backdrop').not('.fv-modal-stack').css('z-index', 1039 + (10 * $('body').data('fv_open_modals')));
        $('.modal-backdrop').not('.fv-modal-stack').addClass('fv-modal-stack'); 

    });        
});
</script>
@endsection
