@extends("home.index")

@section("content")  

<script type="text/javascript">
  function countLiks(id){
    $.ajax({
      url: '{{ url("/likscounter") }}/'+id,
      type: 'get',
      success: function(response){
        $("#c"+id).text(response.likscounter);
        if(response.liked == 1){
          $("#l"+id).removeClass('btn text-grey').addClass('btn text-green');
        }
      }
    })
    .fail(function() {
      console.log("error");
    });
    
  }
  function getprofilephoto (id, postid) {
     $.ajax({
       url: '{{ url("/getprofilepicture") }}/'+id,
       type: 'GET',
       success: function(response){
        $("#profileimage"+postid).attr('src', '{{ url("/postimage") }}/'+response.image);
        $("#profileimages"+postid).attr('src', '{{ url("/postimage") }}/'+response.image);
       }
     }).fail(function() {
       console.log("error");
     });
     
  }
</script>  
@foreach($posts as $post)

  <script type="text/javascript">
    countLiks('{{ $post->id }}');
  </script>     
  <script type="text/javascript">

    getprofilephoto('{{ $post->user_id }}', '{{ $post->id }}');
  </script>   
<div class="post-content"  id="post{{ $post->id }}">

  @php
    $currentdate = date("Y-m-d h:i:s");

    $time = "Just now";

    $seconds = strtotime($currentdate) - strtotime($post->created_at);

    $days    = floor($seconds / 86400);
    $hours   = floor(($seconds - ($days * 86400)) / 3600);
    $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
    $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

    if($hours > 0){
      if(strlen($minutes) == 1){
        $minutes = "0".$minutes;
      }
      $time = "Posted ".$hours." hours ".$minutes. "minutes ago";
    }elseif ($days > 0) {
      $time = "Posted ".$days." days ".$hours. " hours ago";
    }elseif ($days == 0 && $hours == 0 && $minutes == 0) {
      $time = "Just now";
    }elseif ($minutes > 0) {
      $time = "Posted ".$minutes." minutes ago";
    }
  @endphp

  @if(file_exists(public_path()."/postimage/".$post->images))
    <img src="{{ url("/postimage/$post->images") }}" alt="post-image" class="img-responsive post-image" />
  @endif
  <div class="post-container">
    <img src="{{-- {{ url("/postimage/$post->image") }} --}}" id="profileimage{{ $post->id }}" alt="user" class="profile-photo-md pull-left" />
    <div class="post-detail">
      <div class="user-info">
        <h5><a href="#" class="profile-link">{{ $post->firstname }} {{ $post->lastname }}</a> <span class="following"></span></h5>
        <p class="text-muted">{{ $time }}</p>
      </div>
      <div class="reaction">
        <a class="btn text-grey" id="l{{ $post->id }}" onclick="liksPost('{{ $post->id }}')"><i class="icon ion-thumbsup"></i> <span id="c{{ $post->id }}"></span></a>
        @if(Auth::id() == $post->user_id)
        <a type="button" class="btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" >
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" style=" margin-right: 20px;">
          <li style="list-style: none;" onclick="deletePost('{{ $post->id }}')"><a>Delete</a></li>
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
        <a href="{{ url("comments/$post->id") }}" title="">See all comments</a>
      <div class="post-comment">
        <img id="profileimages{{ $post->id }}" alt="" class="profile-photo-sm" />
        <form method="post" action="#" id="commentForm{{ $post->id }}" style="width: 100%">
          <input type="text" class="form-control" id="comnts{{ $post->id }}" placeholder="Post a comment" >
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-12" align="center">
    {{ $posts->links() }}
  </div>
</div>

<script type="text/javascript">
  $("#commentForm{{ $post->id }}").submit(function(event) {
    event.preventDefault();
    var comments = $("#comnts{{ $post->id }}").val();
      if(comments.length > 0){
        $.ajax({
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          url: '{{ url("postcomments") }}',
          type: 'post',
          data: {comments: comments, post_id: '{{ $post->id }}'},
          success: function(response){
            if(response.status){
              $("#commentForm{{ $post->id }}")[0].reset();
              window.location = "comments/{{ $post->id }}";
            }else{
              $.growl.error({ title: "Error!!", message: "Something went wrong please try again" });
            }
          }
        }).fail(function() {
          $.growl.error({ title: "Error!!", message: "Something went wrong please try again" });
        });
      }else{
        $.growl.error({ title: "Error!!", message: "Comment can not be null" });
      }
  });
</script>

@endforeach

<script type="text/javascript">
  function liksPost(id) {
    $.ajax({
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      url: '{{ url("/user/likepost") }}',
      type: 'post',
      data: {postid: id},
      success: function(response){
        if(response.status){
          if(response.flag == 1){
            $("#l"+id).removeClass('btn text-grey').addClass('btn text-green');

            $("#c"+id).text(response.likscounter);
          }else{
            $("#l"+id).removeClass('btn text-green').addClass('btn text-grey');

            $("#c"+id).text(response.likscounter);
          }
        }else{
          $.growl.error({ title: "Error!!", message: "Something went wrong please try again" });
          $("#c"+id).text(response.likscounter);
        }
      }
    }).fail(function(response) {
      $.growl.error({ title: "Error!!", message: "Something went wrong please try again" });
    });
    
  }
</script>

<script type="text/javascript">
  function deletePost(id){
    var htmls = $("#post"+id).html();
    $("#post"+id).attr('align', 'center').html("<img src='{{ url("image/load.gif") }}' class='img-responsive' />");
    $.ajax({
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      url: '{{ url("user/post/") }}/'+id,
      type: 'DELETE',
      success: function(response){
        if(response.status){
          location.reload();
        }else{
          $("#post"+id).html(htmls);
        }
      }
    })
    .fail(function() {
      $.growl.error({ title: "Error!!", message: "Something went wrong please try again" });
    })
    
  }
</script>

<script type="text/javascript">
  function postComment(id, event) {
    var key = event.which;
    if(key == 13){
      
      
    }   
  }
</script>
@endsection