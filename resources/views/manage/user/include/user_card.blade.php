<link rel="stylesheet" href="/css/manage/user/user_card.css">

<div class="col-sm-3">
	<div class="card shadow">
		<img name="profile_picture" class="card-img-top lazy" data-original="{{ ($model->profile_picture) ? ('/upload/user/' . $model->profile_picture) : '/common/images/avatar_male.png'}}" alt="{{$model->name}}">

		<div class="user_card_upload">
			{!! Form::model($model, ["id"=>"user_card_form","enctype"=>"multipart/form-data"]) !!}
				{!! Form::hidden('id') !!}
				{!! Form::hidden('_method', 'POST') !!}

				@if(in_array($logged_in_user->role, array("Owner", "Manager")) || ($logged_in_user->id == $model->id))
				<label for="picture" class="picture" data-label="{{__('message.edit')}}">
					{{__('message.edit')}}
					<input id="picture" name="picture" class="input_file" type="file" accept="image/*" required>
				</label>
				@endif
			{!! Form::close() !!}

		</div>

		<div class="card-body">
			<h4 class="card-title">{{$model->name}}
				@if($user->role == "Manager")
					<i class="fas fa-user-secret text-primary"></i>
				@else
					<i class="fas fa-user-ninja"></i>
				@endif
			</h4>
			<p class="card-text">
				<ul>
					<li><a href="mailto:{{$model->email}}"><span class="fas fa-envelope"></span> {{$model->email}}</a></li>
					@if(isset($departments[$model->department_id]))
					<li>{{$departments[$model->department_id]}}</li>
					@endif
				</ul>
			</p>
		</div>

	</div>
</div>

<script src="/js/manage/user/user_card.js"></script>
