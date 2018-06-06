@extends("home.index")

@section("content")
	@foreach($pplstofollow as $ppl)
	<div class="col-md-6">
		<script type="text/javascript">
			getImages('{{ $ppl->id }}');
		</script>
		<div class="follow-user">
			<img src="{{ url("image/load.gif") }}" alt="" id="is{{ $ppl->id }}" class="profile-photo-sm pull-left" />
			<div>
			  <h5><a href="#">{{ $ppl->firstname }} {{ $ppl->lastname }}</a></h5>
			  <button class="btn  btn-sm btn-primary" id="bs{{ $ppl->id }}" onclick="followusers('{{ $ppl->id }}')"><i class="fa fa-user-plus"></i></button>
			</div>
		</div>
	</div>
	@endforeach
@endsection