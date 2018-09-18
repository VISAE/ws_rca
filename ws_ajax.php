 <?php
 header("Access-Control-Allow-Origin: *");
?>
<!DOCTYPE html>
<html>
<head>
	<title>WebService AJAX</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var base_url = "http://rca.unad.edu.co/api_edunat/v1/";
			var token;
			$.ajax({
				url: base_url+'token',
				dataType: 'json',
				async: false,
				success: function(response){
					token = response.token
				}
			});

			$.ajax({
				url: base_url+'period',
				type: 'GET',
				dataType: 'json',
				async: false,
				contentType: "application/json; charset=UTF-8; charset-uf8 ",
				headers: {
					'Authorization': token
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
     console.log('XMLHttpRequest: ' + JSON.stringify(XMLHttpRequest));
     console.log('textStatus: ' + JSON.stringify(textStatus));
     console.log('errorThrown: ' + JSON.stringify(errorThrown));

     return [];
  },
				success: function(data){
					console.log(data);
				}
			});
		});
		
	</script>
</head>
<body>

</body>
</html>
