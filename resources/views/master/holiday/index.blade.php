@include('_include.master.header',
	[
		'id'				=> 'master_holiday',
		'title'				=> '祭日・祝日・休日',
		'css'				=> 'holiday',
		"datepicker" 		=> true,
	]
)

		<form action="{{ $data['url_pattern'] }}/update" method="post">
			{{ csrf_field() }}
			<input type="hidden" name="add_new" value="{{ $data['add_new'] }}">

			<input type="hidden" name="sRequestYearMonth" value="{{ $sRequestYearMonth }}">
			<input type="hidden" id="sRequestDate" name="sRequestDate" value="{{ $sDbRequestDate }}">
			<input type="hidden" id="data_source_url" value="{{ $data['url_pattern'] }}">

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
					<input type="checkbox" name="holiday[{{ substr($record->date, 0, 10) }}][is_holiday]" value="{{ ($record->is_holiday ? $record->is_holiday : 0) }}" {!! ($record->is_holiday) ? 'checked="checked"' : '' !!}>
					<span class="slider round"></span>
				</label>
				</td>
				<td>
					<input type="text" name="holiday[{{ substr($record->date, 0, 10) }}][name]" value="{{ $record->name }}" class="form-control">
				</td>
			</tr>
			@endforeach

			<tfoot>
			<tr>
				<td colspan="3">
					<div class="w3-center">
						<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="fas fa-pencil-alt"></span> {{__('message.register')}}　　</button>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
		<br>
		</div>


@include('_include.master.footer', [
	"js"			=> "master/holiday",
	"datepicker" 	=> true,
])
