<!DOCTYPE html>
<html>
<head>
    <title>Приложение-задачник</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <link rel="stylesheet" href=" https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href=" <?= (!empty($_SESSION)) ? '/admin' : '/'; ?>">Приложение-задачник</a>
            </div>

            <div class="login pull-right">
                <?php if(!empty($_SESSION)) : ?>
                    <form action="/admin/logout" class="logout-form" method="post">
                        <button type="submit" class="btn btn-default">
                            Sign out
                        </button>
                    </form>
                <?php else : ?>
                    <a class="navbar-brand text-bold site-header-link" href="/login">Sign in</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <div class="container">
        <div class="starter-template">
            <?php include_once('application/views/' . $contentView); ?>
        </div>
    </div>

    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
                    <h4 class="modal-title" id="myModalLabel">Предварительный просмотр</h4>
                </div>
                <div class="modal-body">
                    <h3>Данные задачи</h3>
                    <form #formRef="ngForm">
                        <div class="form-group">
                            <label class="control-label" for="name">Имя:</label>
                            <span class="name">Имя</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">Email:</label>
                            <span class="email" >Email</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Текст:</label>
                            <span class="description">Текст</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="image">Картинка:</label>
                            <span class="image"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script  src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
    <script src="/public/Main.js"></script>
</body>
</html>


