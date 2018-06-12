 <!-- Footer
    ================================================= -->
    <footer id="footer">
      <div class="container">
        <div class="row">
          <div class="footer-wrapper">
            <div class="col-md-3 col-sm-3">
              <a href="#">
                <h1>&nbsp;&nbsp;Social</h1>
              </a>
              <ul class="list-inline social-icons">
                {{-- <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
                <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
                <li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
                <li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
                <li><a href="#"><i class="icon ion-social-linkedin"></i></a></li> --}}
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h5>For individuals</h5>
              <ul class="footer-links">
                <li><a href="#">Signup</a></li>
                <li><a href="#">login</a></li>
                {{-- <li><a href="#">Explore</a></li>
                <li><a href="#">Finder app</a></li>
                <li><a href="#">Features</a></li>
                <li><a href="#">Language settings</a></li> --}}
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h5>For businesses</h5>
              <ul class="footer-links">
                <li><a href="#">Business signup</a></li>
                <li><a href="#">Business login</a></li>
               {{--  <li><a href="#">Benefits</a></li>
                <li><a href="#">Resources</a></li>
                <li><a href="#">Advertise</a></li>
                <li><a href="#">Setup</a></li> --}}
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h5>About</h5>
              <ul class="footer-links">
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
               {{--  <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Help</a></li> --}}
              </ul>
            </div>
            <div class="col-md-3 col-sm-3">
              <h5>Contact Us</h5>
              <ul class="contact">
                <li><i class="icon ion-ios-telephone-outline"></i>+8801620216043</li>
                <li><i class="icon ion-ios-email-outline"></i>aj@social.com</li>
                <li><i class="icon ion-ios-location-outline"></i>Dhaka, Bangladesh</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright">
        <p>Social © {{ date("Y") }}. All rights reserved</p>
      </div>
        </footer>
    
    <!--preloader-->
   {{--  <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>
 --}}
    <div id="profileImage" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <form method="post" id="profileimagechange" enctype="multipart/form-data">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Change profile picture</h4>
          </div>
          <div class="modal-body" align="center" >
            <div id="imagee"></div>
            <input type="file" name="file" id="file" style="display: none;" onchange="preview_image(this)">
            <label for="file" class="btn btn-block btn-primary">
              Choose an image
            </label>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-sm">Change</button>
            <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancle</button>
          </div>
        </div>
      </form>
      </div>
    </div>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ url("js/jquerysticky.min.js") }}"></script>
    <script src="{{ url("js/jquery.scrollbar.min.js") }}"></script>
    <script src="{{ url("js/script.js") }}"></script> 

    <script type="text/javascript">

      $("#postform").submit(function(event) {
        event.preventDefault();
        $.growl.notice({title: "Processing!!", message: "We are processing your request" });
        var formData = new FormData();
        formData.append('postimage', $('#postimage')[0].files[0]);
        formData.append('description', $("#postdescription").val());
        $.ajax({
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          url: '{{ url("user/post") }}',
          type: 'POST',
          data: formData,
          processData: false, 
          contentType: false, 
          success: function(response){
            if(response.status){
              $.growl.notice({ title: "Success!!", message: response.message });
              $.growl.notice({ title: "Processing!!", message: "Now we redirecting" });
              setTimeout(function(){
                location.reload();
              },1000);
            }
          }
        }).fail(function(response) {
          $.each(response.responseJSON.errors, function(index, val) {
            $.growl.error({ title: response.responseJSON.message, message: val[0] });
          });
        });
      }); 
    </script>


    {{-- changing profile picture --}}
    <script type="text/javascript">
      $("#profileimagechange").submit(function(event) {
        event.preventDefault();
        $.growl.notice({title: "Processing!!", message: "We are processing your request" });
          var formData = new FormData();
          formData.append('file', $('#file')[0].files[0]);
          $.ajax({
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            url: '{{ url("/user/changeprofilepicture") }}',
            type: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(response){
              if(response.status){
                $.growl.notice({ title: "Success!!", message: response.message });
                $.growl.notice({ title: "Processing!!", message: "Now we redirecting" });
                setTimeout(function(){
                  location.reload();
                },1000);
              }else{
                $.growl.error({ title: "Error!!", message: response.message });
              }
            }
          })
          .fail(function(response) {
            $.each(response.responseJSON.errors, function(index, val) {
                 $.growl.error({ title: response.responseJSON.message, message: val[0] });
            });
          });
      });
    </script>
   {{--  end of changing profile picture --}}
  </body>
</html>