<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- CSS are placed here --}}
    {!! HTML::style('//fonts.googleapis.com/css?family=Roboto:300,700,400') !!}
    {!! HTML::style('iget-master/material-admin/css/bootstrap.css') !!}
    {!! HTML::style('iget-master/material-admin/css/material-design-iconic-font.min.css') !!}
	{!! HTML::style('iget-master/material-admin/css/admin.css') !!}
	{!! HTML::style('css/app.css') !!}
</head>
<body>
	<div class="container-fluid">
		<div id="error-container" class="paper col-md-4 col-md-offset-4">
			<div class="header">
				<h1>@yield('title')</h1>
			</div>
			<div class="body">
				@yield('description')
			</div>
		</div>
	</div>

	{{-- Scripts are placed here --}}
	<script type="text/javascript" href="//code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" href="{!! versionedFileUrl('js/app/compiled.min.js') !!}"></script>
	<script type="text/javascript" href="{!! versionedFileUrl('js/vendor/compiled.min.js') !!}"></script>
</body>
</html>
