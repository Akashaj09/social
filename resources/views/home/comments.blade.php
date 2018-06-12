@extends("home.index")

@section("content")  


<script type="text/javascript">
  function countLiks(id){
    $.ajax({
      url: '{{ url("/likscounter") }}/'+id,
      type: 'get',
      success: function(response){
        $("#c").text(response.likscounter);
        if(response.liked == 1){
          $("#l").removeClass('btn text-grey').addClass('btn text-green');
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

  function getComentPhoto(id, postid) {
     $.ajax({
       url: '{{ url("/getprofilepicture") }}/'+id,
       type: 'GET',
       success: function(response){
        $("#pf"+postid).attr('src', '{{ url("/postimage") }}/'+response.image);
       }
     }).fail(function() {
       console.log("error");
     });
     
  }
</script>  

<script type="text/javascript">
	countLiks('{{ $posts->id }}');
</script>     
<script type="text/javascript">
	getprofilephoto('{{ $posts->user_id }}', '{{ $posts->id }}');
</script>  
	@php
		$currentdate = date("Y-m-d h:i:s");

	    $time = "Just now";

	    $seconds = strtotime($currentdate) - strtotime($posts->created_at);

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
	<div class="post-content">
		@if(file_exists(public_path()."/postimage/".$posts->images))
			<img src="{{ url("/postimage/$posts->images") }}" alt="post-image" class="img-responsive post-image" />
		@endif
		<div class="post-container">
			<img src="" id="profileimage{{ $posts->id }}" alt="user" class="profile-photo-md pull-left" />
			<div class="post-detail">
				<div class="user-info">
					<h5><a href="timeline.html" class="profile-link">{{ $posts->firstname }} {{ $posts->lastname }}</a> </h5>
					<p class="text-muted">{{ $time }}</p>
				</div>
				<div class="reaction">
					<a class="btn text-grey" id="l" onclick="liksPost('{{ $posts->id }}')"><i class="icon ion-thumbsup"></i>&nbsp;<span id="c"></span></a>
				</div>
				<div class="line-divider"></div>
				<div class="post-text">
					<p>
						{{ $posts->description }}
					</p>
				</div>
				@foreach($comments as $comment)
				<script type="text/javascript">
					getComentPhoto('{{ $comment->user_id }}', '{{ $comment->id }}')
				</script>
				<div class="post-comment">
					<img  alt="" id="pf{{ $comment->id }}" class="profile-photo-sm" />
					<p>
						<a href="#" class="profile-link">{{ $comment->firstname }} </a>&nbsp; {{ $comment->comments }} 
					</p>
				</div>
				@endforeach
				<div class="post-comment">
					<img src="{{ url("postimage/$profilepicture->image") }}" alt="" class="profile-photo-sm" />
					<form method="post" action="#" id="commentForm" style="width: 100%">
						<input type="text" class="form-control" id="comnts" placeholder="Post a comment">
					</form>
				</div>
			</div>
		</div>
    </div>
<script type="text/javascript">
  	$("#commentForm").submit(function(event) {
	    event.preventDefault();
	    var comments = $("#comnts").val();
		if(comments.length > 0){
		$.ajax({
		  headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
		  url: '{{ url("postcomments") }}',
		  type: 'post',
		  data: {comments: comments, post_id: '{{ $posts->id }}'},
		  success: function(response){
		    if(response.status){
		      $("#commentForm")[0].reset();
		      location.reload();
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
@endsection