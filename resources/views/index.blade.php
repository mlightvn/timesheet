@include('_include.user_header',
	[
		'id'				=> 'home',
	]
)

<div class="container">
	<h1>Time Sheet System</h1>
	<br><br>
	<h3>For test user</h3>
	<table class="w3-table w3-striped w3-hoverable">
		<thead class="w3-green">
			<tr>
				<td>email address</td>
				<td>Password</td>
				<td>Note</td>
			</tr>
		</thead>

		<tr>
			<td>owner@coxanh.net</td>
			<td>1</td>
			<td>Owner</td>
		</tr>
		<tr>
			<td>test.manager@coxanh.net</td>
			<td>1</td>
			<td>Manager</td>
		</tr>
		<tr>
			<td>test.user@coxanh.net</td>
			<td>1</td>
			<td>User</td>
		</tr>
	</table>
</div>

<br>
<div class="container">
	Author: Nguyen Ngoc Nam<br>
	LinkedIn: <a href="https://www.linkedin.com/in/nguyenngocnam/">https://www.linkedin.com/in/nguyenngocnam/</a><br>
	About me: <a href="https://coxanh.yen-sao.net/about">https://coxanh.yen-sao.net/about</a>
</div>
@include('_include.user_footer')
