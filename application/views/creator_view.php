<!-- Страница конструктора блогов -->
<script src="/js/ckeditor/ckeditor.js"></script>
<h1>Создание блога</h1>
<div class="constructor">
    <form method="post" enctype="multipart/form-data">
        <div class="constructor__title">
            <h2>Заголовок:</h2>
            <input type="text" name="constructor-title" class="title__input" required>
        </div>
        <div class="note">
            5 изображений - максимум.
        </div>
        <div class="note">
            Для вставки изображения используйте %n%, где n - номер изображения
        </div>
        <button type="button" class="constructor__add-btn" id="add-image">
            Добавить изображение
        </button>
        <button type="button" class="constructor__add-btn added" id="delete-image">
            Удалить изображение
        </button>
        <div class="constructor__content blogview">
            <textarea name="constructor-content" id="editor" rows="20">
            </textarea>
        </div>
        <div class="error-message">
            <?php echo $data; ?>
        </div>
        <input type="submit" value="Опубликовать" name="create-submit" class="creator-btn">
        
    </form>
    
    
    
</div>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>