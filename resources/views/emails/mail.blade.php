<!DOCTYPE html>
<html>
<head>
    <title>ninja11</title>
</head>

<body>

 <h>Hi {{$content['receipent_name']??''}},</p>
 <p> {!! $content['data']??'' !!}</p>
 <h5><b>Regards </b></h5>
 <p>{{$content['sender_name']??'ninja11'}}</p>
</body>

</html>