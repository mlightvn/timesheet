
<div class="w3-row">
	<div class="w3-col s12 m12 l12 w3-card-4">

		<form method="GET" action="{{ $data['url_pattern'] }}" accept-charset="UTF-8" role="search" class="w3-container">
			<div class="w3-row-padding w3-section">
				<div class="w3-col s4 m2 l2">
					<label>ID</label>
					<input class="w3-input w3-border" name="id" type="text">
				</div>
				<div class="w3-col s4 m3 l3">
					<label>{{__('screen.domain.environment.environment')}}</label>
					{{Form::select("development_flag", [
						""=>"-----",
						"1"=>__('screen.domain.environment.production'),
						"2"=>__('screen.domain.environment.staging'),
						"3"=>__('screen.domain.environment.development'),
						"4"=>__('screen.domain.environment.others'),
					],
					NULL,
					["class"=>"w3-input w3-border"]
					)}}
				</div>
				<div class="w3-col s4 m4 l4">
					<label>{{__('screen.domain.name')}}</label>
					<input class="w3-input w3-border" name="name" type="text">
				</div>
				<div class="w3-col s4 m3 l3">
					<label>{{__('screen.domain.detail')}}</label>
					<input class="w3-input w3-border" name="detail" type="text">
				</div>

			</div>
			
			<div class="w3-row-padding w3-section">
				<div class="w3-col s12 m12 l12 w3-right-align">
					<button type="reset" class="w3-btn w3-light-gray" ng-click="reset()">{{__('screen.button.reset')}} <i class="fas fa-sync-alt"></i></button>
					&nbsp;
					<button type="button" class="w3-btn w3-brown" ng-click="loadData()">{{__('screen.button.search')}} <i class="fas fa-search"></i></button>
				</div>
			</div>

		</form>
	</div>
</div>
<br>