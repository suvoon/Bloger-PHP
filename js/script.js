window.addEventListener("DOMContentLoaded", () => {
    let menu_bar = document.querySelector(".menu-bar");

    //Появление тени у навигационной панели при скролле
    window.addEventListener('scroll', function (e) {
        if (this.window.scrollY > 30) {
            menu_bar.classList.add("bar-scrolled");
        }
        else if (this.window.scrollY < 10) {
            menu_bar.classList.remove("bar-scrolled");
        }
    });

    //Вывод сообщения при неправильном формате файла
    let pfp_change = document.querySelector("#pfp-change");
    let pfp_btn = document.querySelector("#pfp-btn");
    if (pfp_change) {
        pfp_change.addEventListener("change", function () {
            if (this.files[0]['type'].split('/')[0] === 'image') {
                if (pfp_btn.nextSibling.classList.contains("error-message")) {
                    pfp_btn.nextSibling.remove();
                }
            }
            else {
                let file_error = document.createElement("div");
                file_error.classList.add("error-message");
                file_error.style.marginTop = "0.2rem";
                file_error.innerHTML = "Некорректный формат изображения";
                pfp_btn.parentNode.insertBefore(file_error, pfp_btn.nextSibling);
                this.value = '';
            }
        });
    }

    //Настройка кнопок добавления и удаления изображений в конструкторе блогов
    let img_button = document.querySelector("#add-image");
    let create_button = document.querySelector(".creator-btn");
    let constructor = document.querySelector(".ck-editor__editable");
    let delete_button = document.querySelector("#delete-image");

    let warning = document.createElement("div");
    warning.classList.add("constructor__warning");
    warning.classList.add("added");
    warning.innerHTML = "Достигнут лимит изображений";

    let el_counter = 0;
    if (img_button) {
        img_button.addEventListener("click", function () {
            let added_el = document.querySelectorAll(".added");
            if (el_counter < 5) {
                let last_el = added_el[added_el.length - 1];
                let img_el = document.createElement("input");
                with (img_el) {
                    classList.add("constructor__img-field");
                    classList.add("added");
                    classList.add("img-field");
                    classList.add(el_counter + "el");
                    type = "file";
                    required = true;
                    setAttribute("name", "constructor-img-" + el_counter++);

                    let file_error = document.createElement("div");
                    file_error.classList.add("constructor__warning");
                    file_error.classList.add("added");
                    file_error.innerHTML = "Некорректный формат изображения";

                    addEventListener("change", function () {
                        if (this.files[0]['type'].split('/')[0] === 'image') {
                            if (this.nextSibling.classList.contains("constructor__warning")) {
                                this.nextSibling.remove();
                            }
                        }
                        else {
                            this.parentNode.insertBefore(file_error, this.nextSibling);
                            this.value = '';
                        }
                    });
                }
                last_el.parentNode.insertBefore(img_el, last_el.nextSibling);
            }
            else {
                added_el[0].parentNode.insertBefore(warning, added_el[0].nextSibling);
            }
        });
        delete_button.addEventListener("click", function () {
            let img_fields = document.querySelectorAll(".img-field");
            let added_el = document.querySelectorAll(".added");
            let fields_len = img_fields.length;
            if (fields_len > 0) {
                if ((img_fields[fields_len - 1].nextSibling.classList) && (img_fields[fields_len - 1].nextSibling.classList.contains("constructor__warning"))) {
                    img_fields[fields_len - 1].nextSibling.remove();
                }
                img_fields[fields_len - 1].remove();
                el_counter--;
                if (added_el[1].classList.contains("constructor__warning")) {
                    added_el[1].remove();
                }
            }
        });
    }

});