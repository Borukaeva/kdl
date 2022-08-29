let elements_list = function ($container) {
    this.container = $container;
    this.init();
}

elements_list.prototype.init = function () {
    this.list = this.container.find(".js-elements_list-list");
    this.btn_add = this.container.find(".js-add");

    let _this = this;
    _this.btn_add.on("click", function () {
        let $add_html = _this.container.find(".js-field_add").first().show();
        _this.initAdd($add_html.find("form"));
        return false;
    });
    _this.initButtons();
    _this.initAnalysisComplex();
}
elements_list.prototype.initAdd = function ($form) {
    let _this = this,
        $btn_submit = $form.find(".js-submit"),
        $btn_cancel = $form.find(".js-cancel"),
        $file_input = $form.find(".file_uploader");

    $btn_cancel.on("click", function () {
        $form.trigger("reset");
        $form.closest(".js-field_add").hide();
        return false;
    });
    $btn_submit.on("click", function () {
        _this.addSubmit($form);
        return false;
    });
    $form.on("submit", function () {
        _this.addSubmit($form);
        return false;
    });
    if ($file_input.length) {
        _this.initFileUpload($file_input);
    }
}
elements_list.prototype.addSubmit = function ($form) {
    let _this = this,
        url = $form.attr("action"),
        data = new FormData($form[0]);
    $.ajax({
        method: "post",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
            $form.find(".error").removeClass("error");
            $form.find(".error_label").hide();
        },
        success: function () {
            _this.reloadList();
        },
        error: function (jqXHR) {
            _this.submitErrors(jqXHR.responseJSON.errors, $form);
        }
    });
}
elements_list.prototype.submitErrors = function (fields, $form) {
    for (let field in fields) {
        $form.find("[name=" + field + "]").addClass("error");
        $form.find("." + field + "_label").text(fields[field][0]).show();
    }
}

elements_list.prototype.initButtons = function () {
    let _this = this;
    _this.list.find(".js-edit").off("click").on("click", function () {
        let $this = $(this),
            $field = $this.closest(".js-field"),
            url = $this.data("href");
        $.ajax({
            method: "GET",
            url: url,
            success: function (html) {
                if ($field.is("tr")) {
                    $field.html(html);
                } else {
                    $field.find(".row").first().replaceWith(html);
                }
                _this.initEdit($field);
            }
        });
        return false;
    });
    _this.list.find(".js-del").off("click").on("click", function () {
        let $this = $(this),
            text = $this.data("delText"),
            result = confirm(typeof text != "undefined" ? text : "Действительно удалить?");
        if (result) {
            let url = $this.data("href"),
                csrf_token = $this.data("csrf-token");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });
            $.ajax({
                method: "DELETE",
                url: url
            })
                .done(function (respons) {
                    console.log(respons);
                    _this.reloadList();
                });
        }
        return false;
    });
    if (_this.list.find(".js-add_sub").length > 0) {
        _this.list.find(".js-add_sub").off("click").on("click", function () {
            let $this = $(this),
                $field = $this.closest(".js-field");
            let $field_add = $field.find('.js-field_add').first().show();
            _this.initAdd($field_add.find("form"));
        });
    }
    if (_this.list.find(".js-status").length > 0) {
        _this.list.find(".js-status").off("change").on("change", function () {
            let $this = $(this),
                url = $this.data("href"),
                csrf_token = $this.data("csrfToken"),
                data = new FormData();
            data.append('active', $this.prop('checked'));
            data.append('_token', csrf_token);

            $.ajax({
                method: "post",
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                data: data
            })
                .fail(function (jqXHR, textStatus) {
                    console.log("Request failed: " + textStatus);
                });
        });
    }
}

elements_list.prototype.initEdit = function ($field) {
    let _this = this,
        $btn_submit = $field.find(".js-submit"),
        $btn_cancel = $field.find(".js-cancel"),
        $form = $field.find("form"),
        $file_input = $form.find(".file_uploader");

    $btn_cancel.on("click", function () {
        let $this = $(this),
            url = $this.data("href");
        $.ajax({
            method: "get",
            url: url,
            cache: false,
        })
            .done(function (html) {
                if ($field.is("tr")) {
                    $field.html(html);
                } else {
                    $field.find("form").first().replaceWith(html);
                }
                _this.initButtons();
            })
            .fail(function (jqXHR, textStatus) {
                console.log("Request failed: " + textStatus);
            });
        return false;
    });

    $btn_submit.on("click", function () {
        _this.editSubmit($form);
        return false;
    });
    $form.on("submit", function () {
        _this.editSubmit($form);
        return false;
    });
    if ($file_input.length) {
        _this.initFileUpload($file_input);
    }
}
elements_list.prototype.editSubmit = function ($form) {
    let _this = this,
        $field = $form.closest(".js-field"),
        url = $form.attr("action"),
        data = new FormData($form[0]);

    $.ajax({
        method: "post",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
            $form.find(".error").removeClass("error");
            $form.find(".error_label").hide();
        },
        success: function (html) {
            if ($field.is("tr")) {
                $field.html(html);
            } else {
                $field.find("form").first().replaceWith(html);
            }
            _this.initButtons();
        },
        error: function (jqXHR) {
            _this.submitErrors(jqXHR.responseJSON.errors, $form);
        }
    });
}

elements_list.prototype.reloadList = function () {
    let _this = this;
    let url = _this.list.data("href");
    $.ajax({
        method: "get",
        url: url,
        success: function (html) {
            _this.list.html(html);
            _this.initButtons();
        }
    });
}

elements_list.prototype.initFileUpload = function ($file_input) {
    let _this = this,
        $form = $file_input.closest("form"),
        $list_item_img = $form.find(".list_item-img"),
        $list_item_img_label = $list_item_img.find("label");
    /*$list_item_img_label
        .on("dragenter", function (e) {
            e.preventDefault();
            $list_item_img.addClass("active");
        })
        .on("dragleave", function (e) {
            e.preventDefault();
            $list_item_img.removeClass("active");
        })
        .on("dragover", function (e) {
            e.preventDefault();
        })
        .on("drop", function (e) {
            e.preventDefault();
            $list_item_img.removeClass("active");
            const file = e.originalEvent.dataTransfer.files[0];
            let src = URL.createObjectURL(file);
            $list_item_img_label.find("img").attr("src", src);
            $list_item_img.find(".file_uploader").value(src);
        });*/
    $file_input.change(function () {
        _this.readURL($form, this);
    });
}
elements_list.prototype.readURL = function ($form, input) {
    let _this = this,
        label = $form.find(".file_uploader_label");
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            label.html($("<img>", {src: e.target.result}));
        }

        reader.readAsDataURL(input.files[0]);
    }

}

elements_list.prototype.initAnalysisComplex = function () {
    if ($(".js-complex").length == 0) return false;

    let _this = this,
        $btn = _this.container.find(".js-complex");

    $btn.on("change", function () {
        let $this = $(this),
            url = $this.data("href"),
            name = $this.attr("name"),
            csrf_token = $this.data("csrfToken"),
            data = new FormData();
        data.append(name, $this.prop('checked'));
        data.append('_token', csrf_token);

        $.ajax({
            method: "post",
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            data: data
        })
            .done(function (html) {
                console.log(html);
            })
            .fail(function (jqXHR, textStatus) {
                console.log("Request failed: " + textStatus);
            });
    });
}

let price_anal_bio = function ($container) {
    this.form = $container;
    this.init();
}
price_anal_bio.prototype.init = function () {
    let _this = this;

    _this.price1 = _this.form.find(".js-price1");
    _this.price2 = _this.form.find(".js-price2");

    _this.price1.on("change", function () {
        _this.priceSubmit();
    });
    _this.price2.on("change", function () {
        _this.priceSubmit();
    });
}
price_anal_bio.prototype.priceSubmit = function () {
    let _this = this,
        url = _this.form.attr("action"),
        data = new FormData(_this.form[0]);
    $.ajax({
        method: "post",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        beforeSend: function () {
        },
        success: function () {
        },
        error: function (jqXHR) {
            _this.submitErrors(jqXHR.responseJSON.errors, _this.form);
        }
    });
}

price_anal_bio.prototype.submitErrors = function (fields, $form) {
    for (let field in fields) {
        $form.find("[name=" + field + "]").addClass("error");
        $form.find("." + field + "_label").text(fields[field][0]).show();
    }
}

$(document).ready(function () {
    if ($(".js-elements_list").length) {
        $(".js-elements_list").each(function () {
            let $list = $(this),
                e_list = new elements_list($list);
        })
    }
    if ($(".js-price_anal_bio").length) {
        $(".js-price_anal_bio").each(function () {
            let $list = $(this),
                e_list = new price_anal_bio($list);
        })
    }
    if ($(".js-search-container").length) {
        $(".js-search-container").btsListFilter(".js-search-input", {
            delay: 300,
            minLength: 1,
            initial: false,
            casesensitive: false,
            resetOnBlur: false,
            emptyNode: function (data) {
                return '<tr class="field js-search-field"><td colspan="3" class="form_row">Нет совпадений</td></tr>';
            },
            itemEl: ".js-search-field",
            itemChild: ".text-gray-dark",
            cancelNode: function () {
                return null;
            }
        });
    }
});
