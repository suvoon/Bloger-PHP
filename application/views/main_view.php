<!-- Главная страница (Последние 10 блогов) -->
<h1>Последние блоги: </h1>
<div class="blog-feed">
        <?php 
        if ($data){
                foreach($data as $blog){
                        echo $blog;
                }
        }
        else echo "<h2>Ничего не найдено</h2>"?>
</div>