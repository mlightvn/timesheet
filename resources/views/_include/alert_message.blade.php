<div class="alert {{ (isset($is_hidden)) ? 'w3-hide' : ''}} {{ (isset($alert_type)) ? $alert_type : session('alert_type')}}">
	<span class="closebtn">&times;</span>  
	<div id="divMessage">{{ (isset($message)) ? $message : session("message") }}</div>
</div>
