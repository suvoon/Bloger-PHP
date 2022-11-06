<!-- Страница редактора блогов -->
<script src="/js/ckeditor/ckeditor.js"></script>
<h1>Редактирование блога</h1>
<div class="constructor">
    <form method="post">
        <div class="constructor__title">
            <h2>Заголовок:</h2>
            <input type="text" name="editor-title" value="<?php echo $data[0][0]?>" class="title__input" required>
        </div>
        <div class="constructor__content blogview">
            <textarea name="editor-content" id="editor" rows="20">
                <?php echo $data[0][1] ?>
            </textarea>
        </div>
        <div class="error-message">
            <?php if ($data[1]) echo $data[1] ?>
        </div>
        <input type="submit" value="Изменить" name="edit-submit" class="creator-btn">
        
    </form>
    
</div>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>