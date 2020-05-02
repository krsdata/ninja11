<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('assets/css/main-style.css') }}">
    <link rel="manifest" href="{{url('manifest.webmanifest')}}">
    <title>Ninjas11</title>
    <script>

        function getTimer(display_id,timer){
        
            // Set the date we're counting down to
            var countDownDate = new Date(timer).getTime();
            // Update the count down every 1 second
            var x = setInterval(function() {
              // Get today's date and time
              var now = new Date().getTime();
              // Find the distance between now and the count down date
              var distance = countDownDate - now;
              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                 
              var time = days + "d " + hours + "h "
              + minutes + "m " + seconds + "s ";
           
              document.getElementById(display_id).innerHTML = time;
              // If the count down is over, write some text 
              if (distance < 0) {
                clearInterval(x);
                document.getElementById(display_id).innerHTML = "EXPIRED";
              }
            }, 1000);
        }
        
        </script>
  </head>
  <body>