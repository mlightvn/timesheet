
<div id="modal" class="modal fade" role="dialog">
	<div class="modal-dialog w3-white">
		<form action="{{ $data['url_pattern'] }}/add" method="post">
			{{ csrf_field() }}
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="modal-title">新規追加</h2>
		</div>
		<div class="modal-body">

			@if(isset($message) || session("message"))
				@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message"))])
			@endif

			<table class="timesheet_table w3-table w3-bordered w3-tiny">
				<tr class="w3-large">
					<th colspan="2">ログイン情報</th>
				</tr>
				<tr>
					<th>{!! Form::label('email', 'email※') !!}</th>
					<td>
						<input class="form-control" placeholder="email" required="required" name="email" type="text" value="" id="email">
					</td>
				</tr>
				<tr>
					<th>{!! Form::label('password', __('message.password')) !!}</th>
					<td>
						<input type="password" name="password" placeholder="{{__('message.password')}}" min="8" max="100" class="form-control">
						<br>
						<label class="w3-text-green">パスワードを入力しない場合は、パスワードが変わらないです。</label>
					</td>
				</tr>
				<tr>
					<th colspan="2"><br></th>
				</tr>
				<tr class="w3-large">
					<th colspan="2">個人情報</th>
				</tr>
				<tr>
					<th>{!! Form::label('name', '名前※') !!}</th>
					<td>
						<input class="form-control" placeholder="名前" required="required" name="name" type="text" value="" id="name">
					</td>
				</tr>
				@if($logged_in_user->role == "Manager")
				<tr>
					<th>{!! Form::label('role', '管理フラグ') !!}</th>
					<td>
						<!-- Rounded switch -->
						<label class="switch">
							<input placeholder="管理フラグ" name="role" type="checkbox" value="Manager" id="role">
							<span class="slider round"></span>
						</label>
					</td>
				</tr>

				<tr>
					<th>{!! Form::label('session_id', '部署') !!}</th>
					<td>
						<select class="form-control" id="session_id" name="session_id"><option disabled="disabled" hidden="hidden" value="">▼下記の項目を選択してください。</option><option value="1" selected="selected">IT事業部</option><option value="2">事業部</option><option value="3">葬祭事業本部</option><option value="4">葬祭サービス部</option><option value="5">人事部</option><option value="8" class="w3-gray">削除</option></select>
					</td>
				</tr>
				@endif
			</table>
			<br>
		</div>
		<div class="modal-footer w3-center">
			<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="glyphicon glyphicon-edit"></span>　{{__('message.register')}}　　</button>
		</div>
		</form>
	</div>
</div>
