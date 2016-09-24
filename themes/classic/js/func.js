function scrollTo(target){
    var offset = $(target).offset().top - $('.static-top').height()
    $('html, body').animate({
        scrollTop: offset
    }, 1000);
}

function checkMaterialsForBlock(obj){
    var wrap = obj.find(' > ul');
    var objinput = obj.find(' > .checkbox input');
    var disabled = (objinput.size()) ? objinput.prop('checked') : true;
    if(wrap.size()){
        wrap.find(' > li').each(function(){
            var input = $(this).find(' > .checkbox input');
            input.prop('disabled', !disabled);
            if(input.prop('checked')){
                input.prop('checked', disabled);
            }
            checkMaterialsForBlock($(this));
        })
    }
}

function deleteImage(obj){
    var box = $(obj).parent();
    var image = box.find("input").attr("id");
	var clone_input = box.find("input").clone();
	box.html("<input id='"+clone_input.attr('id')+"' type='file' name='"+clone_input.attr('name')+"' value=''>")
        box.prepend(clone_input.val(null));
}
function getLangPrefix(){
    if ($("body").data("lang")) return "/"+$("body").data("lang")+"/";
    return "/";
}
function openCenteredWindow(url, name, width, height) {
    if(!width) width = 940;
    if(!height) height = 600;
    var left = parseInt((screen.availWidth/2) - (width/2));
    var top = parseInt((screen.availHeight/2) - (height/2));
    var windowFeatures = "width=" + width + ",height=" + height + ",status,scrollbars=yes,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;
    var blockWndow = window.open(url, name, windowFeatures);
    blockWndow.focus();
}
function runTimer(obj) {
    obj.hide();
    var d = 60;
    $('.counter').html('Отослать повторно СМС можно через <span>' + d + '</span> сек.');
    var timer;
    function sec() {
        d--;
        if (d <= 0) {
            clearInterval(timer);
            $('.counter').empty();
            obj.show();
        } else {
            $('.counter span').text(d)
        }
    }
    timer = setInterval(sec, 1000);

}
function submitCalculatorForm() {
    var url = $("#FuelsCalculator-form").attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: $("#FuelsCalculator-form").serialize(), // serializes the form's elements.
        success: function (html)
        {
            $('.calculator .tabs').html(html);
            unifyHeights();
        }
    });
}
function unifyHeights() {
    var maxHeight = 0;
    $('.calculator .nav-tabs a').each(function () {
        var height = $(this).outerHeight();
        //alert(height);
        if (height > maxHeight) {
            maxHeight = height;
        }
    });
    $('.calculator .nav-tabs a').css('height', maxHeight);
}
function submitSmsForRequest(obj) {
    var link = obj;
    $.get(link.attr('href')).done(function () {
        runTimer(link);
    })
}
function openLinkInModal(obj) {
    var href = obj.attr('href');
    $.get(href, function (data) {
        $('#modal').html(data)
        $('#modal').modal('show');
    })
}
function showMsgBox(status, msg) {
    $("#msg-box").html("<div class='alert alert-" + status + "'>" + msg + "</div>");
    setTimeout(clearMsgBox, 2000)
}
function clearMsgBox() {
    $("#msg-box .alert").fadeOut(function () {
        $(this).remove()
    })
}
function checkMsg() {
    if (!$("#msg-box").is(":empty")) {
        $("#msg-box").show();
        setTimeout(clearMsgBox, 2000)
    }
}
function serialize(mixed_value) {
    var _getType = function (inp) {
        var type = typeof inp, match;
        var key;
        if (type == 'object' && !inp) {
            return 'null';
        }
        if (type == "object") {
            if (!inp.constructor) {
                return 'object';
            }
            var cons = inp.constructor.toString();
            if (match = cons.match(/(\w+)\(/)) {
                cons = match[1].toLowerCase();
            }
            var types = ["boolean", "number", "string", "array"];
            for (key in types) {
                if (cons == types[key]) {
                    type = types[key];
                    break;
                }
            }
        }
        return type;
    };
    var type = _getType(mixed_value);
    var val, ktype = '';

    switch (type) {
        case "function":
            val = "";
            break;
        case "undefined":
            val = "N";
            break;
        case "boolean":
            val = "b:" + (mixed_value ? "1" : "0");
            break;
        case "number":
            val = (Math.round(mixed_value) == mixed_value ? "i" : "d") + ":" + mixed_value;
            break;
        case "string":
            val = "s:" + mixed_value.length + ":\"" + mixed_value + "\"";
            break;
        case "array":
        case "object":
            val = "a";
            var count = 0;
            var vals = "";
            var okey;
            var key;
            for (key in mixed_value) {
                ktype = _getType(mixed_value[key]);
                if (ktype == "function") {
                    continue;
                }

                okey = (key.match(/^[0-9]+$/) ? parseInt(key) : key);
                vals += serialize(okey) +
                        serialize(mixed_value[key]);
                count++;
            }
            val += ":" + count + ":{" + vals + "}";
            break;
    }
    if (type != "object" && type != "array")
        val += ";";
    return val;
}