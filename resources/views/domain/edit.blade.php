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
	<a href="{{ $data['url_pattern'] }}" class="w3-button w3-brown"><span class="fas fa-list-ul"></span></a>&nbsp;
	<a href="{{ $data['url_pattern'] }}/add" class="w3-button w3-brown"><span class="fas fa-plus"></span></a>
	<br><br>
</div>

<div class="w3-row">

	@if(isset($model))
	<div class="w3-bar w3-light-gray">
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}">Domain</a>
		<a class="w3-bar-item w3-button" href="{{ $data['url_pattern'] }}/edit/{{ $model->id }}/upload">Key file</a>
	</div>
	@endif

	{!! Form::model($model, ['ng-app'=>'', 'ng-init'=>"url='" . $model->url . "';admin_url='" . $model->admin_url . "';repository_url='" . $model->repository_url . "'"]) !!}
	{!! Form::hidden('id') !!}
	{!! Form::hidden('organization_id') !!}

	@if(isset($message) || session("message"))
		@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
	@endif

	<table class="timesheet_table w3-table-all w3-striped w3-bordered">

		<tr>
			<td colspan="3"><h2>Domain</h2>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('name', 'ドメイン名') !!} <span class="w3-text-red">※</span></th>
			<th><button type="button" name="btnCopy" value="name"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'ドメイン名', 'required'=>'required']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('development_flag', '環境') !!}</th>
			<th><button type="button" name="btnCopy" value="development_flag"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::select('development_flag', ['1'=>'本番', '2'=>'ステージング', '3'=>'開発', '4'=>'その他'], NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('url', 'url') !!}</th>
			<th><button type="button" name="btnCopy" value="url"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::input('url', 'url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://', 'ng-model'=>'url']) !!}
				<a href="@{{url}}" target="_blank">@{{url}}</a>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('admin_url', '管理のurl') !!}</th>
			<th><button type="button" name="btnCopy" value="admin_url"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::input('url', 'admin_url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://', 'ng-model'=>'admin_url']) !!}
				<a href="@{{admin_url}}" target="_blank">@{{admin_url}}</a>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('admin_username', '管理のユーザ名') !!}</th>
			<th><button type="button" name="btnCopy" value="admin_username"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('admin_username', null, ['class'=>'form-control', 'placeholder'=>'管理のユーザ名']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('admin_password', '管理のパスワード') !!}</th>
			<th><button type="button" name="btnCopy" value="admin_password"><i class="fas fa-copy"></i></button></th>
			<td>
				<input type="password" id="admin_password" name="admin_password" value="{{ $model->admin_password }}" class="form-control raku-textbox-asterisk" autocomplete="off" current-password="off">
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('description', 'Detail') !!}</th>
			<th><button type="button" name="btnCopy" value="description"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<td colspan="3"><h2>Repository (GitHub, BitBucket, ...)</h2>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('repository_url', 'Repository url') !!}</th>
			<th><button type="button" name="btnCopy" value="repository_url"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::input('url', 'repository_url', NULL, ['class'=>'form-control', 'placeholder'=>'http(s)://', 'ng-model'=>'repository_url']) !!}
				<a href="@{{repository_url}}" target="_blank">@{{repository_url}}</a>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('repository_username', 'Username') !!}</th>
			<th><button type="button" name="btnCopy" value="repository_username"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('repository_username', NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('repository_password', 'Password') !!}</th>
			<th><button type="button" name="btnCopy" value="repository_password"><i class="fas fa-copy"></i></button></th>
			<td>
				<input type="password" id="repository_password" name="repository_password" value="{{$model->repository_password}}" class="form-control raku-textbox-asterisk" autocomplete="off" current-password="off">
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('repository_description', 'Detail') !!}</th>
			<th><button type="button" name="btnCopy" value="repository_description"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('repository_description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tr>
			<td colspan="3"><h2>SSH</h2>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('ssh_access_command', 'SSH connection') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_access_command"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('ssh_access_command', NULL, ['class'=>'form-control', 'placeholder'=>'SSH接続']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('ssh_host', 'Host') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_host"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('ssh_host', null, ['class'=>'form-control', 'placeholder'=>'Username']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('ssh_username', 'Username') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_username"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('ssh_username', null, ['class'=>'form-control', 'placeholder'=>'Username']) !!}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('ssh_password', 'Password') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_password"><i class="fas fa-copy"></i></button></th>
			<td>
				<input type="password" id="ssh_password" name="ssh_password" value="{{$model->ssh_password}}" class="form-control raku-textbox-asterisk" autocomplete="off" current-password="off">
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('ssh_description', 'Detail') !!}</th>
			<th><button type="button" name="btnCopy" value="ssh_description"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('ssh_description', NULL, ['class'=>'form-control', 'placeholder'=>'Detail']) !!}
			</td>
		</tr>

		<tr>
			<td colspan="3"><h2>Database information</h2>
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_access_command', 'DB connection') !!}</th>
			<th><button type="button" name="btnCopy" value="db_access_command"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('db_access_command', NULL, ['class'=>'form-control', 'placeholder'=>'DB接続']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_host', 'Host') !!}</th>
			<th><button type="button" name="btnCopy" value="db_host"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('db_host', NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_name', 'Database name') !!}</th>
			<th><button type="button" name="btnCopy" value="db_name"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('db_name', NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_username', 'User name') !!}</th>
			<th><button type="button" name="btnCopy" value="db_username"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::text('db_username', NULL, ['class'=>'form-control']) !!}
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_password', 'Password') !!}</th>
			<th><button type="button" name="btnCopy" value="db_password"><i class="fas fa-copy"></i></button></th>
			<td>
				<input type="password" id="db_password" name="db_password" value="{{$model->db_password}}" class="form-control raku-textbox-asterisk" autocomplete="off" current-password="off">
			</td>
		</tr>

		<tr>
			<th>{!! Form::label('db_description', 'Detail') !!}</th>
			<th><button type="button" name="btnCopy" value="db_description"><i class="fas fa-copy"></i></button></th>
			<td>
				{!! Form::textarea('db_description', NULL, ['class'=>'form-control', 'placeholder'=>'詳細']) !!}
			</td>
		</tr>

		<tfoot>
		<tr>
			<td colspan="3">
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

@include('_include.admin_footer')
