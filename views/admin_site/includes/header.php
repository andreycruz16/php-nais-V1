<head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/nichiyu.ico">
      <title>Nichiyu Inventory System - Administrator</title>
      <!-- Bootstrap Styles-->
      <link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FontAwesome Styles-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- Morris Chart Styles-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
      <!-- Custom Styles-->
      <link href="assets/css/custom-styles-admin.css" rel="stylesheet" />
      <!-- Google Fonts-->
      <link href='assets/css/opensans-font.css' rel='stylesheet' type='text/css' />
      <link rel="stylesheet" href="assets/js/Lightweight-Chart/cssCharts.css"> 
      <!-- <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /> -->
      <link href="../../assets/css/dataTables.bootstrap.min.css" rel="stylesheet" />
      <link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
      <link href="../../assets/calendar/css/responsive-calendar.css" rel="stylesheet">   
      <!-- BOOTSTRAP DIALOG -->
      <link href="assets/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" /> 
      <script>
        function startTime() {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // var h=<?php date_default_timezone_set('Asia/Manila'); echo date('h', time()); ?>;
            // var m=<?php date_default_timezone_set('Asia/Manila'); echo date('i', time()); ?>;
            // var s=<?php date_default_timezone_set('Asia/Manila'); echo date('s', time()); ?>;
            m = checkTime(m);
            s = checkTime(s);
            if(h == 12)
            {
            document.getElementById('time').innerHTML = h+":"+m+":"+s+" PM";
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 13)
            {
            document.getElementById('time').innerHTML = "01:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 14)
            {
            document.getElementById('time').innerHTML = "02:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 15)
            {
            document.getElementById('time').innerHTML = "03:"+m+":"+s+" PM";
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 16)
            {
            document.getElementById('time').innerHTML = "04:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 17)
            {
            document.getElementById('time').innerHTML = "05:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 18)
            {
            document.getElementById('time').innerHTML = "06:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 19)
            {
            document.getElementById('time').innerHTML = "07:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 20)
            {
            document.getElementById('time').innerHTML = "08:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 21)
            {
            document.getElementById('time').innerHTML = "09:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 22)
            {
            document.getElementById('time').innerHTML = "10:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 23)
            {
            document.getElementById('time').innerHTML = "11:"+m+":"+s+" PM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else if (h == 0)
            {
            document.getElementById('time').innerHTML = "12:"+m+":"+s+" AM"; 
            var t = setTimeout(function(){startTime()},500);
            }
            else
            {
            document.getElementById('time').innerHTML = h+":"+m+":"+s+" AM";
            var t = setTimeout(function(){startTime()},500);
            }
        }

        function checkTime(i) {
            if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }

        // window.onload = function(){
        //     startTime();
        // }
      </script>
</head>