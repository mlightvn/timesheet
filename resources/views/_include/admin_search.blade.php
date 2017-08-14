<div class="w3-row">
	<div class="w3-col s12 m12 l12">

		<form method="GET" action="{{ \Request::url() }}" accept-charset="UTF-8" role="search">

			<div class="form-group form-inline">
				<label class="control-label" for="keyword">キーワード：</label>

				<div class="input-group">
					<input placeholder="キーワード" class="form-control" id="keyword" name="keyword" type="text" value="{{ (isset($keyword) ? $keyword : '') }}">

					<span class="input-group-btn">
						<button type="submit" class="btn w3-brown"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
				<button type="reset" class="btn w3-brown"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>

		</form>
	</div>
</div>
