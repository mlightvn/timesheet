
<div id="modal" class="modal fade" role="dialog">
	<div class="modal-dialog w3-white">
		<form id="modalForm" action="javascript:void(0);" method="post">
			{{ csrf_field() }}

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="modal-title">{{__('message.add')}}</h2>
		</div>

		<div id="alert" class="alert collapse">
			<div id="divMessage"></div>
		</div>
		<div class="modal-body">
			<table class="timesheet_table w3-table-all w3-striped w3-bordered">
				<tr>
					<th>{!! Form::label('name', __('message.department') . '※') !!}</th>
					<td>
						{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('message.department'), 'required'=>'required']) !!}
					</td>
				</tr>
			</table>
		</div>
		<div class="modal-footer w3-center">
			<button type="submit" class="w3-button w3-brown w3-xlarge">　　<span class="glyphicon glyphicon-edit"></span>　{{__('message.register')}}　　</button>
		</div>
		</form>
	</div>
</div>
