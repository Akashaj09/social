@extends("welcome") 

@section("title", "Conectivity || Login and sign up")

@section("content")
<div class="row">
    <div class="col-xs-12 d-block d-sm-none bg-white pd-10 w-100">
        <form method="post" id="loginform">
            <div class="row form-group">
                <div class="col">
                    <label for="emaillogin">Email</label>
                    <input type="email" class="form-control" id="emaillogin" name="email" placeholder="Email">
                </div>
                <div class="col">
                    <label for="passwordlogin">Password</label>
                    <input type="password" id="passwordlogin" class="form-control" name="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" value="1" id="remember" />&nbsp; <label for="remember">Remember me</label>
            </div>
            <div class="form-group" align="right">
                <button type="submit" class="btn btn-outline-primary">Login</button>
            </div>
        </form>
        Or create an account
    </div>
</div>      
<div class="row">
    <div  class="col-md-5 bg-white pd-10">
        <br>
        <form method="post" id="registerform">
            <div class="row form-group">
                <div class="col">
                    <label for="firstname">First name</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name">
                </div>
                <div class="col">
                    <label for="lastname">Last name</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="registeremail">Email address</label>
                <input type="email" class="form-control" id="registeremail" name="registeremail" placeholder="Enter email">
                <small>Please insert a valid email address</small>
            </div>
            <br>
            <div class="form-group">
                <label for="registerpassword">Password</label>
                <input type="password" class="form-control" id="registerpassword" name="registerpassword" placeholder="Password">
            </div>
            <br>
            <div class="form-group">
                <label for="registerrepass2">Re-type Password</label>
                <input type="password" class="form-control" id="registerrepass2" name="registerrepass2" placeholder="Password">
            </div>
            <br>
            <div class="form-group">
                <label for="birthdate">Birth date</label>
                <input id="datepicker" class="form-control" name="datebirth" placeholder="YYYY/MM/dd" />
            </div>
            <div class="form-group" align="right">
                <button type="submit" class="btn btn-outline-primary">Create an account</button>
            </div>
        </form>
    </div>
    <div  class="col-md-7 pdt-40 bg-white d-none d-sm-none d-md-block">
        <img src="{{ url("image/social.png") }}" class="responsive">
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript">
    $("#registerform").submit(function(event) {
        $.growl.notice({title: "Processing!!", message: "We are processing your request" });
        var formData = $("#registerform").serialize();
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.growl.notice({title: "Processing!!", message: "Still processing" });
        $.ajax({
            url: '{{ url("/user/register") }}',
            type: 'POST',
            data: formData,
            success: function(response){
               if(response.status){
                $.growl.notice({title: "Success!!", message: "Account successfully created" });
                $.growl.notice({title: "Redirect!!", message: "Now we are redirecting" });
                setTimeout(function(){
                    window.location = "/verify/"+$("#registeremail").val();
                },1000);
               }else{
                $.growl.error({ title: "Errors!!", message: response.error });
               }
            }
        })
        .fail(function(response) {
            $.each(response.responseJSON.errors, function(index, val) {
                 $.growl.error({ title: response.responseJSON.message, message: val[0] });
            });
        });
        
        event.preventDefault();
    });
</script>


    <script type="text/javascript">
        $("#loginform").submit(function(event) {
            event.preventDefault();
            formData = $("#loginform").serialize();
            $.growl.notice({title: "Processing!!", message: "We are processing your request" });
            $.ajax({
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                url: '{{ url("/login") }}',
                type: 'POST',
                data: formData,
                success: function(response){
                    if(response.status){
                        $.growl.notice({title: "Processing!!", message: "Trying to logged in" });
                        if(response.login){
                            $.growl.notice({title: "Success!!", message: "Logged in and redirecting" });
                            setTimeout(function(){
                                window.location = "/home";
                            }, 2000);
                        }
                    }else{
                        $.growl.error({ title: "Errors!!", message: response.message });
                    }
                }
            })
            .fail(function(response) {
                console.log(response);
            });
        });
    </script>

@endsection