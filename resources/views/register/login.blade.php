@extends("welcome") 

@section("title", "Login")

@section("content")  
<br>
	<div class="row bg-white pd-10">
		<div class="col-md-6 offset-md-3">
			<br>
			<form method="post">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" required name="email" placeholder="Email" class="form-control" id="email">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" required name="password" placeholder="Password" class="form-control" id="password">
				</div>
				<div class="form-group">
					<input type="checkbox" name="remember" value="1" id="remember" />&nbsp; <label for="remember">Remember me</label>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-outline-primary">
						Login
					</button>&nbsp;
					<a href="{{ url("/") }}">Don't have an account sign up here?</a>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$("form").submit(function(event) {
			event.preventDefault();
			formData = $("form").serialize();
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