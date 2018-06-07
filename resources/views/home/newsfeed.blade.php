@extends("home.index")

@section("content")    
@foreach($posts as $post)        
<div class="post-content">

  @php
    $currentdate = date("Y-m-d h:i:s");

    $seconds = strtotime($currentdate) - strtotime($post->created_at);

    $days    = floor($seconds / 86400);
    $hours   = floor(($seconds - ($days * 86400)) / 3600);
    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
    $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

    if($hours > 0){
      if(strlen($minutes) == 1){
        $minutes = "0".$minutes;
      }
      $time = "Published ".$hours." hours ".$minutes. "minutes ago";
    }elseif ($days > 0) {
      $time = $days."  ".$hours;
    }elseif ($days == 0 && $hours == 0 && $minutes == 0) {
      $time = "Just now";
    }
  @endphp

  @if(file_exists(public_path()."/postimage/".$post->images))
    <img src="{{ url("/postimage/$post->images") }}" alt="post-image" class="img-responsive post-image" />
  @endif
  <div class="post-container">
    <img src="{{ url("/postimage/$post->image") }}" alt="user" class="profile-photo-md pull-left" />
    <div class="post-detail">
      <div class="user-info">
        <h5><a href="#" class="profile-link">{{ $post->firstname }} {{ $post->lastname }}</a> <span class="following">following</span></h5>
        <p class="text-muted">{{ $time }}</p>
      </div>
      <div class="reaction">
        <a class="btn text-green"><i class="icon ion-thumbsup"></i> 13</a>
        <a class="btn text-red"><i class="fa fa-thumbs-down"></i> 0</a>
        @if(Auth::id() == $post->user_id)
        <a type="button" class="btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" >
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" style=" margin-right: 20px;">
          <li style="list-style: none;"><a href="#">Delete</a></li>
        </ul>
        @endif
      </div>
      <div class="line-divider"></div>
      <div class="post-text">
        @if(strlen($post->description) < 100)
          <h2>{{ $post->description }}</h2>
        @else
          <p>{{ $post->description }}</p>
        @endif
      </div>
      <div class="line-divider"></div>
      <div class="post-comment">
        <img src="images/users/user-11.jpg" alt="" class="profile-photo-sm" />
        <p><a href="timeline.html" class="profile-link">Diana </a><i class="em em-laughing"></i> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud </p>
      </div>
      <div class="post-comment">
        <img src="images/users/user-4.jpg" alt="" class="profile-photo-sm" />
        <p><a href="timeline.html" class="profile-link">John</a> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud </p>
      </div>
      <div class="post-comment">
        <img src="images/users/user-1.jpg" alt="" class="profile-photo-sm" />
        <input type="text" class="form-control" placeholder="Post a comment">
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection