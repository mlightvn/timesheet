@include('_include.admin_header',
	[
		'id'				=> 'admin_profile_organization',
	]
)

<div class="w3-row">
	<h1>企業</h1>
	<br>
</div>

<div class="w3-row">
	<table class="timesheet_table w3-table w3-bordered">
		<tr>
			<th>{!! Form::label('name', '企業名※') !!}</th>
			<td>
				{{ $model->name }}
			</td>
		</tr>
		<tr>
			<th>代表取締役社長</th>
			<td>{{ $model->ceo }}
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('website', 'Website') !!}</th>
			<td>
				<a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a>
			</td>
		</tr>
		<tr>
			<th>{!! Form::label('description', '詳細') !!}</th>
			<td>
				{!! nl2br($model->description) !!}
			</td>
		</tr>

	</table>
	<br>
	{!! Form::close() !!}
</div>

@include('_include.admin_footer')
