<?php
include ("db.php");
error_reporting(0);
session_start();


$profile=$_SESSION['$user'];
echo " welcome".$profile ;
$query = " SELECT * FROM USERS WHERE username='$profile'";
$data = mysqli_query($con , $query);
$result= mysqli_fetch_assoc($data);  
echo $result['email'];
$quer = " SELECT * FROM GEOFENCE WHERE username='$profile'";
$dat = mysqli_query($con , $quer);
$fence= mysqli_fetch_assoc($dat);  
echo $fence['lat1'];
?>

<html>
  <head>
    <title>ASSET TRACKER</title>

	<script type="text/javascript" src="jquery2.js"></script>
	<script type="text/javascript" src="npm.js"></script>
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.19.0.min.js"></script>
    <link rel="stylesheet" href="map2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  <body>
      <p align="right">
        <a href="login.php">
          <span class="glyphicon glyphicon-log-out" color="white"> log out </span>
        </a>
      </p>
     <div class="bg-others"> 
    <div class="container">
	<h1 >ASSET SECURITY TRACKER</h1>
        <h2 >Realtime GPS Tracker with Raspberry PI</h2>
        <center><hr style="height:2px; border:none; color:#ffffff; background-color:#ffffff; width:35%; margin: 0 auto 0 auto;"></center>
        <center><button class="btn btn-success col-sm-3" id="action">Start Tracking</button></center><br>
		
		<p id="demo"></p>
		<p  id="d"></p>
		<p style="display:none;">
		
		<form method="post">
		<p id="u" style="display:none;" >  <button class="btn btn-danger col-sm-3" id="ac" type="submit" name="submit" > Mail </button>
		
		</form></p>
        <center><div id="map-canvas"></div></center>
    </div>
          </div>
<input type="hidden" id="str" name="str" value="" /> 
    <script>
    window.lat = <?php echo $result['initial_lat']; ?>;
    window.lng = <?php echo $result['initial_lng']; ?>;

    var map;
    var mark;
    var lineCoords = [];
	
      
    var initialize = function() {
      map  = new google.maps.Map(document.getElementById('map-canvas'), {center:{lat:lat,lng:lng},zoom:12});
      mark = new google.maps.Marker({position:{lat:lat, lng:lng}, map:map});
	  
    };
	
    window.initialize = initialize;
	
	

    var redraw = function(payload) {

      if(payload.message.lat){
      lat = payload.message.lat;
      lng = payload.message.lng;
	  
      map.setCenter({lat:lat, lng:lng, alt:0});
      mark.setPosition({lat:lat, lng:lng, alt:0});
      var e=new google.maps.LatLng(lat, lng) 
	 // q=lat.tofixed(4);
	 // w=lng.tofixed(4);
	 // var qw="(" +q + "," +w + ")";
      lineCoords.push(e);
	//  locate.push(qw);
	  
	 document.cookie = "e = " +e;
	 var lineCoordinatesPath = new google.maps.Polyline({
        path: lineCoords,
        geodesic: true,
        strokeColor: '#2E10FF'
      });
	  lineCoordinatesPath.setMap(map);
	  var triangleCoords = [
          {lat: <?php echo $fence['lat1']; ?>, lng: <?php echo $fence['lng1']; ?> },
		  {lat: <?php echo $fence['lat2']; ?> , lng: <?php echo $fence['lng2']; ?> },
          {lat: <?php echo $fence['lat3']; ?> , lng:<?php echo $fence['lng3']; ?> },
          {lat: <?php echo $fence['lat4']; ?>, lng: <?php echo $fence['lng4']; ?> }
        ];

        // Construct the polygon.
        //var bermudaTriangle = new google.maps.Polygon({paths: triangleCoords});
		var bermudaTriangle = new google.maps.Polygon({
          paths: triangleCoords,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#FF0000',
          fillOpacity: 0.01
        });
		 bermudaTriangle.setMap(map);
	   
		function chckfence (e , lt , ln){
			var x = document.getElementById("myAudio");
	     var txt = google.maps.geometry.poly.containsLocation(e, bermudaTriangle) ?
              "within fence" :
              "out of fence";
			  
			  if (txt == "out of fence"){
				  
			  document.getElementById("demo").innerHTML = txt;
			  //var mail=f;
			  var a=ln.toFixed(4);
			  var b =  lt.toFixed(4);
			 var n = "longitude : " + a;
			 var t = " latitude : " + b;
			// locate.push((a,b));
			 
			 document.getElementById("demo").innerHTML = t;
			 document.getElementById("d").innerHTML = n ;
			
				document.cookie = "t = " +t;
				document.cookie = "n = " +n;
				//document.cookie = "e = " +e;
			  document.getElementById("u").style.display="block";
			  
			  
			  }else{ document.getElementById("demo").innerHTML = txt;
			  document.getElementById("u").style.display="none";
			  }}
			  
        
      }
	  
	chckfence(e, lat, lng);
	document.cookie = "lineCoords = " +lineCoords;
		var postData = function(){
              $.ajax(
                {
                  method:"post",
                  data:{lineCoords:lineCoords},
                  success: function(data){
                    console.log(data);
                  }
                });
            };
            window.postdata = postData;
            
    };
	//document.cookie = "locate = " +locate;	



    var pnChannel = "raspi-tracker";

    var pubnub = new PubNub({
      publishKey: <?php echo $result['api1'];?>,
      subscribeKey:  <?php echo $result['api2'];?>
    });
        
    document.querySelector('#action').addEventListener('click', function(){
        var text = document.getElementById("action").textContent;
        if(text == "Start Tracking"){
            pubnub.subscribe({channels: [pnChannel]});
            pubnub.addListener({message:redraw});
            document.getElementById("action").classList.add('btn-danger');
            document.getElementById("action").classList.remove('btn-success');
            document.getElementById("action").textContent = 'Stop Tracking';
			
        }
        else{
            pubnub.unsubscribe( {channels: [pnChannel] });
            document.getElementById("action").classList.remove('btn-danger');
            document.getElementById("action").classList.add('btn-success');
            document.getElementById("action").textContent = 'Start Tracking';
        }
        });
		$(document).ready(function(){ 
		  $('#btn').click(function(){ // prepare button inserts the JSON string in the hidden element 
		    $('#str').val(JSON.stringify(lineCoords)); 
		  }); 
		}); 
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCdXNCIZdA_rsjwIlMqLGf_s7Bb04I_TpM&callback=initialize"></script>
 
<script>
function newPoint(time) {
      var radius = 0.01;
      var x = Math.random() * radius;
      var y = Math.random() * radius;
      return {lat:window.lat + y, lng:window.lng + x};
      }
      setInterval(function() {
      pubnub.publish({channel:pnChannel, message:newPoint()});
      }, 500);
</script>


			  
<?php
if(isset($_POST['submit'])){
	  
		require_once 'C:\xampp\htdocs\map\mailer/class.phpmailer.php';
		require_once 'C:\xampp\htdocs\map\mailer/class.smtp.php';
		/* creates object */
		$mail = new PHPMailer(true);
		$mailid = $result['email'] ;
		$subject = "ALERT : DEVICE OUT OF GEO-FENCE";
		$text_message = "Hello";
		//$message = "(latitude , longitude) : " .$_COOKIE['e'];
		//$message. = "longitude : " .$_COOKIE['n'];
		//$m = 
		$message1 = $_COOKIE['t'];
		$message2 = $_COOKIE['n'];
		$message = $message1."<br>".$message2;
		try
		{
		$mail->IsSMTP();
		$mail->isHTML(true);
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = '465';
		$mail->AddAddress($mailid);
		$mail->Username ="fabsohini@gmail.com";
		$mail->Password ="sohini@16";
		$mail->SetFrom('fabsohini@gmail.com','ASSET TRACKING SYSTEM');
		//$mail->AddReplyTo("divyasundarsahu@gmail.com","Divyasundar Sahu");
		$mail->Subject = $subject;
		$mail->Body = $message;
		//$mail->Body = $message2;
		//$mail->AltBody = $message;
		if($mail->Send())
		{
		echo "Thank you for register u got a notification through the mail you provide";
		}
		}
		catch(phpmailerException $ex)
		{
		$msg = "
		".$ex->errorMessage()."
		";
		}
					//$text = 'Stop Tracking' ; //echo " <script> document.getElementById("action").textContent </script> ";
			//$i = 0;
			
				//$str = json_decode($_POST['str'], true); 
				$locate = ($_COOKIE['locate']);
				//echo ".$locate.";
				//$size= sizeof($str);
				
					//$value = $locate[$i];
					foreach($locate as $value){
					$sql = "INSERT INTO locations(user, locate) VALUES('$profile', '$value')";
					
				
					mysqli_query($con,$sql);
					}

              //$m = $_COOKIE['e'];
             
            
			
		

}

?>



</body>
</html>