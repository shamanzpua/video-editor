<?php
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
<script type="text/javascript">
    // setInterval(function() {
    //     fetch('/article/fetch/user.json')
    //         .then(function(response) {
    //             return response.json();
    //         })
    //         .catch(  );
    // }, 2000);
</script>
{{--<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    {{--<video src="video\3.mp4" width="400" height="300" controls ></video>--}}
    {{--<video src="video\4.mp4" width="400" height="300" controls ></video>--}}
        <div class="flex-center position-ref full-height">


            <form method="post">
                @csrf
                <input type="text" placeholder="First video url" name="first_url" value="<?= $input['first_url'] ?? ''?>"/>
                <input placeholder="First video start time" type="text" name="first_start" value="<?= $input['first_start'] ?? ''?>"/>
                <input placeholder="First video duration" type="text" name="first_duration" value="<?= $input['first_duration'] ?? ''?>"/>
                <input placeholder="Second video url" type="text" name="second_url" value="<?= $input['second_url'] ?? ''?>"/>
                <input placeholder="Second video start time" type="text" name="second_start" value="<?= $input['second_start'] ?? ''?>"/>
                <input placeholder="Second video duration" type="text" name="second_duration" value="<?= $input['second_duration'] ?? ''?>"/>
                <input type="submit" name="createVideo" value="Send" />
                <!-- Form Contents -->
            </form>
        </div>
    </body>
</html>
