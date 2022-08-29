<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="/laboratory_assistant/css/jquery-ui.css" rel="stylesheet">
    <link href="/laboratory_assistant/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css" rel="stylesheet" integrity="sha512-f0tzWhCwVFS3WeYaofoLWkTP62ObhewQ1EZn65oSYDZUg1+CyywGKkWzm8BxaJj5HGKI72PnMH9jYyIFz+GH7g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <div class="container mt-5 mb-5" style="width: 400px">
        <h3>Date picker</h3>
        <input type="text" id="datetimepicker" class="form-control">
    </div>

    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!--script src="/laboratory_assistant/js/datepicker-ru.js"></script-->
    <script src="/laboratory_assistant/js/jquery-ui-timepicker-addon.min.js"></script>
    <script src="/laboratory_assistant/js/jquery-ui-timepicker-ru.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" integrity="sha512-+UiyfI4KyV1uypmEqz9cOIJNwye+u+S58/hSwKEAeUMViTTqM9/L4lqu8UxJzhmzGpms8PzFJDzEqXL9niHyjA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#datetimepicker").datetimepicker({
            timepicker: true,
            datepicker: true,
            format: "Y-m-d",
            value: "2019-08-01",
            weeks: true
        });
    </script>
</body>
</html>
