@include('_include.master.header',
	[
		'id'				=> 'master_organization',
	]
)

@if (in_array($logged_in_user->permission_flag, array("Administrator")))
<div class="w3-row">
	<h1>ユーザー</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model, ['ng-app'=>'', 'ng-init'=>"website='" . $model->website . "'"]) !!}
	{!! Form::hidden('id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table w3-bordered">
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
					<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-pencil"></span>　登録　　</button>
				</div>
			</td>
		</tr>
		</tfoot>
	</table>
	<br>
	{!! Form::close() !!}
</div>
@else
<div class="w3-row">
	<h1 class="w3-text-red">許可なし</h1>
</div>
@endif

@include('_include.master.footer')
