@extends("welcome") 

@section("title", "Please verify your aaccount")

@section("content")  
<br>
	<div class="row bg-white pd-10">
		<div class="col-md-6 offset-md-3">
			<br>
			<form method="post">
				<div class="form-group">
					<label for="code">Enter the vaerification code</label>
					<input type="text" id="code" required name="code" placeholder="Verification code" class="form-control" />
					<small>We have sended  a four digit code in your {{ Request::route('email') }}. Please verify the code to activate your account. This code will valid for 1 days</small>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-outline-primary">Verify</button>
				</div>
			</form>
			<br>
		</div>
	</div>
	<script type="text/javascript">
		$("form").submit(function(event) {
			$.growl.notice({title: "Processing!!", message: "We are processing your request" });
			var code = $("#code").val();
			event.preventDefault();
			$.ajax({
				headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
				url: '{{ url("verify") }}',
				type: 'POST',
				data: { email: '{{ Request::route('email') }}', code: code },
				success: function(response){
					if(response.status){
						$.growl.notice({title: "Success!!", message: "Verified" });
						if(response.session){
							setTimeout(function(){
								window.location = "/login";
							}, 1000);
						}
						setTimeout(function(){
							$.growl.notice({title: "Processing!!", message: "Trying to logged in" });
						}, 2000);
						if(response.login){
							$.growl.notice({title: "Success!!", message: response.message });
							$.growl.notice({title: "Processing!!", message: "Now we redirecting..." });
							setTimeout(function(){
								window.location = "/home";
							}, 1000);
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