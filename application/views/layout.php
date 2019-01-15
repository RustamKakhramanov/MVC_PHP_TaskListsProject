<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">TestTask</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item rounded-left">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item rounded-right">
                        <a class="nav-link" href="<?=$_SESSION['id']? '/site/logout': '/site/login'?>"><?=$_SESSION['id']?'Logout':'Login'?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container content">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/application/views/'.$content_view; ?>
    </div>
    <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
    <script>
        function taskText(text) {
            var parent = $(text).closest('.item-task-body');
            var id = $(parent).children('#id-task').html();
            if(!$("#update-text-form").html()){
                textBody = $(text).html();
                $(text).html("<form id='update-text-form' method='post' action='/site/update-task-body' ><input type='hidden' name='id' value='"+id+"'><textarea name='body' id='bdt' class='task-text-textarea'>" + $(text).html() + "</textarea> <button type='button' onclick='updateTask($(this))' class='btn btn-primary save-btn'>Save</button> </form>");
                textContainer = $('#update-text-form');
                $("#update-text-form").children('#bdt').focus();
            }
        }
        function updateStatus(status) {
            var data = $(status).html() == 'No completed' ? 2 : 1;
            var parent = $(status).closest('.item-task-body');
            var id = $(parent).children('#id-task').html();
            $.ajax({
                type: 'POST',
                data: {
                    status: data,
                    id: id
                },
                url: '/site/update-task-body',
                success: function (data) {
                }
            });
            $(status).html(data == 2 ? 'Completed' : 'No completed');
        }
    </script>
    <script type="text/javascript" src="/assets/js/main.js"></script>
</body>
</html>
