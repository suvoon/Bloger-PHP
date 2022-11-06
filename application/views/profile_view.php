<!-- Страница Публичного профиля пользователя -->
<div class="profile">
    <div class="profile__image">
        <?php echo $data[0] ?>
    </div>
    <div class="profile__info">
        <h1 class="profile__name">
            <?php echo $data[1] ?>
        </h1>
        <div class="profile__about">
            <?php echo $data[2] ?>
        </div>
    </div>
</div>
<h1>Блоги пользователя:</h1><br/>
<div class="blog-feed">

        <?php foreach($data as $k => $blog){
                if($k > 2) echo $blog;
            }?>
        
</div>