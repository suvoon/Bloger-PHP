<!-- Страница панели администратора -->
<h2>Поиск пользователя:</h2>
<div class="admin-search">
    <form method="post">
        <input type="text" name="admin-usersearch" class="admin-input">
        <input type="submit" name="admin-usersubmit" value="Найти" class="admin-querybtn">
    </form>
</div>

<div class="admin-query">
    <?php if ($data[0]){
        foreach ($data[0] as $user){
            echo $user;
        }
    }?>
</div>
<h2>Поиск блога по заголовку или имени пользователя:</h2>
<div class="admin-search">
    <form method="post">
        <input type="text" name="admin-blogsearch" class="admin-input">
        <input type="submit" name="admin-blogsubmit" value="Найти" class="admin-querybtn">
    </form>
</div>
<div class="admin-query">
    <?php if ($data[1]){
        foreach ($data[1] as $blog){
            echo $blog;
        }
    }?>
</div>