@include('_include.admin_header',
	[
		'id'				=> 'domain_list',
	]
)

<div class="w3-row">
	<h1>ドメイン</h1>
	<br>
</div>

<div class="w3-row">
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="glyphicon glyphicon-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">
	{!! Form::model($model, ['ng-app'=>'', 'ng-init'=>"url='" . $model->url . "';admin_url='" . $model->admin_url . "';repository_url='" . $model->repository_url . "'"]) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('organization_id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">
		<tr>
			<th>{!! Form::label('name', 'ドメイン名') !!} <span class="w3-text-red">※</span></th>
			<th><button type="button" name="btnCopy" value="name"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'ドメイン名', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('development_flag', '環境') !!}</th>
			<th><button type="button" name="btnCopy" value="development_flag"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::select('development_flag', ['0'=>'本番', '1'=>'ステージング', '2'=>'開発', ], NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('url', 'url') !!}</th>
			<th><button type="button" name="btnCopy" value="url"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::input('url', 'url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://', 'ng-model'=>'url']) !!}
				<a href="@{{url}}" target="_blank">@{{url}}</a>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('admin_url', '管理のurl') !!}</th>
			<th><button type="button" name="btnCopy" value="admin_url"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::input('url', 'admin_url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://', 'ng-model'=>'admin_url']) !!}
				<a href="@{{admin_url}}" target="_blank">@{{admin_url}}</a>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('admin_username', '管理のユーザ名') !!}</th>
			<th><button type="button" name="btnCopy" value="admin_username"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('admin_username', null, ['class'=>'form-control', 'placeholder'=>'管理のユーザ名']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('admin_password', '管理のパスワード') !!}</th>
			<th><button type="button" name="btnCopy" value="admin_password"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('admin_password', null, ['class'=>'form-control raku-textbox-asterisk', 'placeholder'=>'管理のパスワード', 'autocomplete'=>'off', 'current-password'=>'off']) !!}
			</td>
		</tr>


		<tr>
			<th>{!! Form::label('repository_url', 'repository_url') !!}</th>
			<th><button type="button" name="btnCopy" value="repository_url"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::input('url', 'repository_url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://', 'ng-model'=>'repository_url']) !!}
				<a href="@{{repository_url}}" target="_blank">@{{repository_url}}</a>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', '詳細情報') !!}</th>
			<th><button type="button" name="btnCopy" value="description"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('ssh_access_command', 'SSH接続') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_access_command"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('ssh_access_command', NULL, ['class'=>'form-control', 'placeholder'=>'SSH接続']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('ssh_description', 'SSH情報') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_description"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('ssh_description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_access_command', 'DB接続') !!}</th>
			<th><button type="button" name="btnCopy" value="db_access_command"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::text('db_access_command', NULL, ['class'=>'form-control', 'placeholder'=>'DB接続']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_description', 'DB情報') !!}</th>
			<th><button type="button" name="btnCopy" value="db_description"><i class="fa fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('db_description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tfoot>
		<tr>
			<td colspan="3">
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

@include('_include.admin_footer')
