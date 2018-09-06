@include('_include.master.header',
	[
		'id'				=> 'master_organization',
	]
)

<div class="w3-row">
	<h1>{{__('screen.master.organization.organization')}}</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model, ['ng-app'=>'', 'ng-init'=>"website='" . $model->website . "'"]) !!}
	{!! Form::hidden('id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="table table-bordered">
		<tr>
			<th>{!! Form::label('name', '企業名※') !!}</th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'企業名', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('slug', 'Slug※') !!}</th>
			<td>
				{!! Form::text('slug', null, ['class'=>'form-control', 'placeholder'=>'slug', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>代表取締役社長</th>
			<td>
				{{ $logged_in_user->name }}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('website', 'Website') !!}</th>
			<td>
				{!! Form::input('url', 'website', null, ['class'=>'form-control', 'placeholder'=>'Website', 'ng-model'=>'website']) !!}
				<a href="@{{website}}" target="_blank">@{{website}}</a>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('description', '詳細') !!}</th>
			<td>
				{!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tfoot>
		<tr>
			<td colspan="2">
				<div class="w3-center">
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-pencil-alt"></span>　{{__('message.register')}}　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.master.footer')
