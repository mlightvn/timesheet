@if ((isset($list)) && ($list->lastPage() > 1))
<div class="w3-row">
	<div class="w3-col s12 m12 l12 w3-center">
		{{ $list->appends(array('keyword' => (isset($keyword) ? $keyword : NULL)))->render() }}
	</div>
</div>
@endif
