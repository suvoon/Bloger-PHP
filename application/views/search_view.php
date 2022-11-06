<!-- Страница результатов поискового запроса -->
<h1>Найдено по запросу: </h1>
<div class="blog-feed">
        <?php 
        if ($data){
                foreach($data as $blog){
                        echo $blog;
                }
        }
        else echo "<h2 class='text-center'>Ничего не найдено</h2>"?>
</div>