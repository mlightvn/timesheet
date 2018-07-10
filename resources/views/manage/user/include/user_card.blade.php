<div class="col-sm-3">
	<div class="card">
		<img name="profile_picture" class="card-img-top" src="{{ ($model->profile_picture) ? ('/upload/user/' . $model->profile_picture) : '/common/images/avatar_male.png'}}" alt="{{$model->name}}">
		<div class="card-body">
			<h4 class="card-title">{{$model->name}}
				@if($user->session_is_manager == "Manager")
					<i class="fas fa-user-secret text-primary"></i>
				@else
					<i class="fas fa-user-ninja"></i>
				@endif
			</h4>
			<p class="card-text">
				<ul>
					<li>{{$model->email}}</li>
					<li>{{$departments[$model->session_id]}}</li>
				</ul>
			</p>
		</div>
	</div>
</div>
