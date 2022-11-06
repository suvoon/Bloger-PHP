<!-- Страница настроек пользователя -->
<h1>Настройки пользователя:</h1>
<h2>Аватар профиля:</h2>
<div class="settings-change">
    <div class="settings-change__current">
        <p>Текущий:</p>    
        <div class="current__avatar">
            <?php 
                if ($login_data[1]){
                    echo '<img alt="Profile Picture" src="data:image/jpg;base64,' . $login_data[1] . '" />';
                }
                else echo '<img src="/images/no-image.jpg" />';
            ?>
        </div>
    </div>
    <div class="settings-change__new">
        <p>Изменить:</p> 
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="profile-picture" id="pfp-change" required>
            <input type="submit" value="Изменить" name="pfp-change-submit" id="pfp-btn" class="submit-btn">
        </form>
    </div>
</div>
<div class="error-message">
    <?php echo $data[1]; ?>
</div>
<h2>Имя профиля:</h2>
<div class="settings-change">
    <div class="settings-change__current">
        <p>Текущее:</p>    
        <div class="current__username">
            <?php echo $_SESSION['username'];?>
        </div>
    </div>
    <div class="settings-change__new">
        <p>Изменить:</p> 
        <form method="post">
            <input type="text" name="username" class="username-field" required>
            <input type="submit" value="Изменить" name="uname-change-submit" class="submit-btn">
        </form>
    </div>
</div>
<div class="error-message">
    <?php echo $data[2]; ?>
</div>
<h2>Описание профиля:</h2>
<div class="settings-change">
    <div class="settings-change__current">
        <p>Текущее:</p>    
        <div class="current__desc">
            <?php echo $data[0] ?>
        </div>
    </div>
    <div class="settings-change__new">
        <p>Изменить:</p> 
        <form method="post">
            <textarea name="description" class="desc-field" rows="5" cols="30" required></textarea>
            <input type="submit" value="Изменить" name="desc-change-submit" class="submit-btn">
        </form>
    </div>
</div>
<div class="error-message">
    <?php echo $data[3]; ?>
</div>
<h1>Ваши блоги:</h1>
<div class="your-blogs">
    <?php foreach($data[4] as $your_blog) echo $your_blog; ?>
</div>