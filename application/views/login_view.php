<h1>Страница авторизации</h1>

<div style="margin:25px 0 25px 0;">
<form class="form-horizontal" method="post" action="/login">
    <div class="form-group">
        <label class="control-label col-sm-1" for="login">Логин:</label>
        <div class="col-sm-4">
            <input type="text" required class="form-control" id="login" name="login" placeholder="Введите логин">
            <div class="help-block"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-1" for="pwd">Пароль:</label>
        <div class="col-sm-4">
            <input type="password" required class="form-control" id="password" name="password" placeholder="Введите пароль">
            <div class="help-block"></div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-4">
            <button type="submit" class="btn btn-default">Войти</button>
        </div>
    </div>
</form>
</div>

<?php //extract($data); ?>
<?php //if($login_status=="access_granted") { ?>
<!--    <p style="color:green">Авторизация прошла успешно.</p>-->
<?php //} elseif($login_status=="access_denied") { ?>
<!--    <p style="color:red">Логин и/или пароль введены неверно.</p>-->
<?php //} ?>
