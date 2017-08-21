@include('_include.admin_header',
	[
		'id'				=> 'holiday',
		'title'				=> '祭日・祝日・休日',
		'css'				=> 'holiday',
	]
)

		<form action="{{ \Request::url() }}/update" method="post">
			{{ csrf_field() }}
			<input type="hidden" name="add_new" value="{{ $data['add_new'] }}">

			<input type="hidden" name="sRequestYearMonth" value="{{ $sRequestYearMonth }}">
			<input type="hidden" id="sRequestDate" name="sRequestDate" value="{{ $sDbRequestDate }}">

			<div class="w3-row w3-col s12 m12 l12">
				<div class="w3-center">
						<span id="datepicker"></span>
				</div>
				<br><br>
			</div>

			@if(session("message"))
			<div class="w3-row">
				@include('_include.alert_message', ["message" => (isset($message) ? $message : session("message")), "alert_type" => (isset($alert_type) ? $alert_type : session("alert_type"))])
			</div>
			@endif

		<div class="w3-row">
		<a href="/admin/holiday" class="w3-button w3-brown"><span class="glyphicon glyphicon-list"></span></a>&nbsp;
		<br><br>
		<table class="timesheet_table w3-table-all w3-hoverable w3-bordered">
			<thead>
			<tr class="w3-brown">
				<th nowrap="nowrap">日</th>
				<th></th>
				<th></th>
			</tr>
			</thead>

			@foreach($data["arrList"] as $key => $record)
			<tr class="{{ ($record->is_holiday) ? 'w3-gray' : '' }}">
				<td align="right">
					{{ date("Y/m/d", strtotime($record->date)) }}
				</td>
				<td>
				<label class="switch">
					<input type="checkbox" name="holiday[{{ substr($record->date, 0, 10) }}][is_holiday]" value="{{ ($record->is_holiday ? $record->is_holiday : 0) }}" {!! ($record->is_holiday) ? 'checked="checked"' : '' !!} {!! ($logged_in_user->session_is_manager == "Manager") ? '' : 'disabled="disabled"'!!}>
					<span class="slider round"></span>
				</label>
				</td>
				<td>
					<input type="text" name="holiday[{{ substr($record->date, 0, 10) }}][name]" value="{{ $record->name }}" class="form-control" {!! ($logged_in_user->session_is_manager == "Manager") ? '' : 'readonly="readonly"'!!}>
				</td>
			</tr>
			@endforeach

			@if($logged_in_user->session_is_manager == "Manager")
			<tfoot>
			<tr>
				<td colspan="3">
					<div class="w3-center">
						<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fa fa-edit"></span> 登録　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
			@endif
		</table>
		</form>
		<br>
		</div>


@include('_include.admin_footer', [
	"js"			=> "holiday",
])
