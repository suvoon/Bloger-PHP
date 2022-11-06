<!-- Страница Блога -->
<h1><?php echo $data[0] ?> </h1>
<a <?php echo "href='/profile/".urlencode($data[1])."'"?>>
    <h2 class="underline">Создатель: <?php echo $data[1] ?></h2>
</a>
<div class="blogview">
    <?php echo $data[2] ?>
</div>