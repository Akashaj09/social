@include("script.head")
<style type="text/css" media="screen">
  .text-grey{
    color: #708090;
  }
</style>
<script type="text/javascript">
  function getImage(id) {
    $.ajax({
      url: '{{ url("user/getUserimage") }}/'+id,
      type: 'get',
      success: function(response){
        var image = response.image;

        $("#i"+id).attr('src', 'postimage/'+image["image"]);
      }
    });
    
  }

  function getImages(id) {
    $.ajax({
      url: '{{ url("user/getUserimage") }}/'+id,
      type: 'get',
      success: function(response){
        var image = response.image;

        $("#is"+id).attr('src', 'postimage/'+image["image"]);
      }
    });
    
  }
</script>
    <div id="page-contents">
        <div class="container">
            <div class="row">

          <!-- Newsfeed Common Side Bar Left
          ================================================= -->
          <div class="col-md-3 static">
            <div class="profile-card">
              @if($profilepicture)
                <img src="{{ url("postimage/$profilepicture->image") }}" alt="user" class="profile-photo" />
              @else
                <img src="{{ url("postimage/people.png") }}" alt="" class="profile-photo" />  
              @endif
                <h5><a href="#" class="text-white">{{ Auth::user()->firstname }}</a></h5>
                <a href="#" class="text-white"><i class="ion ion-android-person-add"></i> {{ $followercount }} followers</a><br>
                <a href="#" class="text-white"><i class="ion ion-android-person-add"></i> {{ $followingcount }} follwing</a>
                <button class="btn btn-primary btn-block btn-sm" data-toggle="modal" data-target="#profileImage"  data-toggles="tooltip" title="Change profile picture">Change image</button>
            </div><!--profile card ends-->
            <ul class="nav-news-feed">
              <li><i class="icon ion-ios-paper"></i><div><a href="{{ url("/") }}">My Newsfeed</a></div></li>
              <li><i class="icon ion-ios-people"></i><div><a href="{{ url("/people") }}">People to follow</a></div></li>
              {{-- <li><i class="icon ion-ios-people-outline"></i><div><a href="{{ url("/friendds") }}">Friends</a></div></li> --}}
              {{-- <li><i class="icon ion-chatboxes"></i><div><a href="newsfeed-messages.html">Messages</a></div></li>
              <li><i class="icon ion-images"></i><div><a href="newsfeed-images.html">Images</a></div></li>
              <li><i class="icon ion-ios-videocam"></i><div><a href="newsfeed-videos.html">Videos</a></div></li> --}}
            </ul><!--news-feed links ends-->
            {{-- <div id="chat-block">
              <div class="title">Chat online</div>
              <ul class="online-users list-inline">
                <li><a href="newsfeed-messages.html" title="Linda Lohan"><img src="images/users/user-2.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="Sophia Lee"><img src="images/users/user-3.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="John Doe"><img src="images/users/user-4.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="Alexis Clark"><img src="images/users/user-5.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="James Carter"><img src="images/users/user-6.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="Robert Cook"><img src="images/users/user-7.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="Richard Bell"><img src="images/users/user-8.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="Anna Young"><img src="images/users/user-9.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
                <li><a href="newsfeed-messages.html" title="Julia Cox"><img src="images/users/user-10.jpg" alt="user" class="img-responsive profile-photo" /><span class="online-dot"></span></a></li>
              </ul>
            </div> --}}<!--chat block ends-->
          </div>
          <div class="col-md-7">
            

            @if(!isset($post))
            <!-- Post Create Box
            ================================================= -->
            <div class="create-post"  style="padding: 0px 10px 10px 10px;">
              <div class="row">
                <form method="post" action="{{ url("user/post") }}" enctype="multipart/form-data" id="postform">
                  <div class="col-md-12 col-sm-12" style="padding: 0px;">
                    <div>
                      <div class="panel panel-success" style="padding: 0px;">
                        <div class="panel-body">
                          <div class="col-md-2 col-sm-2 col-xs-2" style="padding: 0px;">
                            @if($profilepicture)
                            <img src="{{ url("postimage/$profilepicture->image") }}" alt="" class="profile-photo-md" />   
                            @else
                            <img src="{{ url("postimage/people.png") }}" alt="" class="profile-photo-md" />  
                            @endif
                          </div>
                          <div class="col-md-10 col-sm-10 col-xs-10" style="padding: 0px;">
                            <textarea class="form-control" name="postdescription" id="postdescription" rows="3" style="resize: none;" placeholder="What's on your mind"></textarea>
                          </div>
                        </div>
                        <div class="panel-footer" style="height: 57px;">
                          <div class="col-md-7 col-sm-7 col-xs-7" align="left" style="padding: 2px;">
                            <input id="postimage" type="file" name="postimage"style="display: none;" />
                            <label class="btn btn-primary btn-sm" for="postimage" data-toggle="tooltip" title="Choose an image"><i class="fa fa-image"></i></label>
                          </div>
                          <div class="col-md-5 col-sm-5 col-xs-5" align="right" style="padding: 2px;">
                            <button type="submit" class="btn btn-primary btns-sm"  data-toggle="tooltip" title="Create post" id="post">Post</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div><!-- Post Create Box End-->
            @endif
            @yield('content')
          </div>

          <!-- Newsfeed Common Side Bar Right
          ================================================= -->
          <div class="col-md-2 static">
            <div class="suggestions visible-lg visible-md" id="sticky-sidebar">
              <h4 class="grey">Who to Follow</h4>
              @foreach($peoplestofollow as $people)
              <script type="text/javascript">
                getImage('{{ $people->id }}');
              </script>
              <div class="follow-user">
                <img src="{{ url("image/load.gif") }}" alt="" id="i{{ $people->id }}" class="profile-photo-sm pull-left" />
                <div>
                  <h5><a href="#">{{ $people->firstname }} {{ $people->lastname }}</a></h5>
                  <button class="btn  btn-sm btn-primary" id="b{{ $people->id }}" onclick="followuser('{{ $people->id }}')"><i class="fa fa-user-plus"></i></button>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          </div>
        </div>
    </div>
    <script type="text/javascript">
      function followuser(id){
        $("#b"+id).attr('disabled', true).html("<img src='{{ url("image/load.gif") }}' height='20px' />");
        $.growl.notice({title: "Processing!!", message: "We are processing your request" });
        $.ajax({
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          url: '{{ url("user/followuser") }}',
          type: 'POST',
          data: {userid: id},
          success: function(response){
            if(response.status){
              if(response.fl == 1){
                $("#b"+id).attr('disabled', false).html("<img src='{{ url("image/unfollow.png") }}' height='20px' />");
              }else{
                $("#b"+id).attr('disabled', false).html('<i class="fa fa-user-plus"></i>');
              }
            }
          }
        });
      }


      function followusers(id){
        $("#bs"+id).attr('disabled', true).html("<img src='{{ url("image/load.gif") }}' height='14px' />");
        $.growl.notice({title: "Processing!!", message: "We are processing your request" });
        $.ajax({
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          url: '{{ url("user/followuser") }}',
          type: 'POST',
          data: {userid: id},
          success: function(response){
            if(response.status){
              if(response.fl == 1){
                $("#bs"+id).attr('disabled', false).html("<img src='{{ url("image/unfollow.png") }}' height='14px' />");
                $("#b"+id).attr('disabled', false).html("<img src='{{ url("image/unfollow.png") }}' height='20px' />");
              }else{
                $("#bs"+id).attr('disabled', false).html('<i class="fa fa-user-plus"></i>');
                $("#b"+id).attr('disabled', false).html('<i class="fa fa-user-plus"></i>');
              }
            }
          }
        });
      }
    </script>
@include("script.footer")