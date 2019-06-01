
<div class="w3-row">
	<div class="w3-col s12 m12 l12 w3-card-4 w3-light-grey">

		<form method="GET" action="{{ $data['url_pattern'] }}" accept-charset="UTF-8" role="search" class="w3-container">
			<div class="w3-row-padding w3-section">
				<div class="w3-col s4 m2 l2">
					<label>ID</label>
					<input class="w3-input w3-border" name="id" type="text">
				</div>
				<div class="w3-col s4 m4 l4">
					<label>{{__('screen.user.name')}}</label>
					<input class="w3-input w3-border" name="name" type="text">
				</div>
				<div class="w3-col s4 m2 l2">
					<label>{{__('screen.user.gender')}}</label>
					<div class="w3-col s12 m12 l12">
						<input class="w3-radio" type="radio" id="gender_unknown" name="gender" value="" checked="checked">
						<label for="gender_unknown">{{__('screen.user.unknown')}}</label>
						<br>
						<input class="w3-radio" type="radio" id="gender_male" name="gender" value="0">
						<label for="gender_male">{{__('screen.user.male')}}</label>
						&nbsp;&nbsp;
						<input class="w3-radio" type="radio" id="gender_female" name="gender" value="1">
						<label for="gender_female">{{__('screen.user.female')}}</label>
					</div>
				</div>
				<div class="w3-col s4 m4 l4">
					<label>{{__('screen.common.email')}}</label>
					<input class="w3-input w3-border" name="email" type="text">
				</div>

			</div>
			
			<div class="w3-row-padding w3-section">
				<div class="w3-col s12 m12 l12 w3-right-align">
					<button type="button" class="w3-btn w3-brown" ng-click="loadData()">{{__('message.search')}} <i class="fas fa-search"></i></button>
				</div>
			</div>

		</form>
	</div>
</div>
<br><br>