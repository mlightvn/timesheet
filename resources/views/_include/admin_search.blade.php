<div class="w3-row">
	<div class="w3-col s12 m12 l12">

		<form method="GET" action="{{ $data['url_pattern'] }}" accept-charset="UTF-8" role="search">
			<div class="w3-row w3-section">
				<div class="w3-col s8 m6 l6">
					<input class="w3-input w3-border" id="keyword" name="keyword" type="text" placeholder="検索キーワード" value="{{ (isset($keyword) ? $keyword : '') }}">
				</div>
				<div class="w3-col s4 m3 l3">
					<button type="submit" class="w3-button w3-brown"><span class="glyphicon glyphicon-search"></span></button>
					<button type="reset" class="w3-button w3-brown"><span class="glyphicon glyphicon-refresh"></span></button>
				</div>
			</div>

		</form>
	</div>
</div>
