$(document).ready(function() {
    var textBody;
    var textContainer;
    $(".task-text").on('click',function() {
        var parent = $(this).closest('.item-task-body');
        var id = $(parent).children('#id-task').html();
       if(!$("#update-text-form").html()){
            textBody = $(this).html();
            $(this).html("<form id='update-text-form' method='post' action='/site/update-task-body' ><input type='hidden' name='id' value='"+id+"'><textarea name='body' id='bdt' class='task-text-textarea'>" + $(this).html() + "</textarea> <button type='button' onclick='updateTask($(this))' class='btn btn-primary save-btn'>Save</button> </form>");
            textContainer = $('#update-text-form');
            $("#update-text-form").children('#bdt').focus();
        }
    });
    $(document).mouseup(function (e) {
        if ($(textContainer).has(e.target).length === 0){
            $(textContainer).closest('.task-text').html(textBody);
        }
    });
        $('form').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
});
function updateTask(param){
    var form =  $(param).closest('form'),
        container = $(form).closest('.task-text'),
        type = $(form).attr("method"),
        url = $(form).attr("action"),
        data = $(form).serialize();
    $.ajax({
        type: type,
        data: data,
        url:url,
        success: function(data){
           $(container).html(data);
        }
    });
}
$('.update-status').on('click',function() {
    var data = $(this).html() == 'No completed'?2:1;
    var parent = $(this).closest('.item-task-body');
    var id = $(parent).children('#id-task').html();
    $.ajax({
        type: 'POST',
        data:{
            status: data,
            id: id
        } ,
        url:'/site/update-task-body',
        success: function(data){
        }
    });
    $(this).html(data == 2?'Completed':'No completed');
});

$("#user-form").on("submit", function(e){
    e.preventDefault();
    var type = $(this).attr("method"),
        data = $(this).serialize();
    $.ajax({
        type: type,
        data: data,
        success: function(data){
           $('#error').html(data);
           if(!data)
               window.location.href="../";
        }
    });
});
$("form").on("click", function(e){
    $("#error").html("");
});
$('#create-button').on('click', function () {
    $('#task-create').show();
    $('#task-body').trigger('focus');
});
$('#create-button').on('click', function(){
    if($(this).text() == 'Create task')
        showModal();
    else
        closeModal();
});

$("#task-image").change(function () {
    var fileName = $(this).val().replace('C:\\fakepath\\','');
    var type = fileName.search(/^.*\.(?:jpg|jpeg|png|gif)\s*$/ig);
    if(type == 0){
        $('#label-image-file').html(fileName);
        $('#error-tsks').html('');
    }
    else{
        $('#error-tsks').html('file incorrect');
        $('#label-image-file').html('Choose image...');
    }
});

$('#task-preview').on('click',function(e){
    var body = $('#create-body').val();
    var imgSelected = document.getElementById("task-image").files;
    var emailBody = $('#exampleInputEmail1').val();

    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if(imgSelected[0] !== undefined)
        var type = imgSelected[0]['name'].search(/^.*\.(?:jpg|jpeg|png|gif)\s*$/ig);
    if(body !== '' && imgSelected.length > 0 && type == 0 && emailBody != '' ){
        if (reg.test(emailBody) == false){
            $('#error-tsks').html('Email is incorrect');
            $(this).attr('data-target', '');
        }
        if(body !== '' && imgSelected.length > 0 && type == 0 && emailBody != '' && reg.test(emailBody) == true){
            $(this).attr('data-target', '.bd-example-modal-md');
            var fileToLoad = imgSelected[0];
            var fileReader = new FileReader();
            fileReader.onload = function (fileLoadedEvent) {
                var srcData = fileLoadedEvent.target.result; // <--- data: base64
                var newImage = document.createElement('img');
                newImage.src = srcData;
                $(newImage).attr('id','preview-img');
                document.getElementById("modal-task-image").innerHTML = newImage.outerHTML;
            }
            fileReader.readAsDataURL(fileToLoad);
            $('#modal-task-body').html(body);
            $('#modal-email').html(emailBody);
            $('#error-tsks').html('');
        }
    }
    else{
        $(this).attr('data-target', '');
        $('#error-tsks').html('Complete the task completely');
    }
});


$('#asd').click(function( event ){
    event.stopPropagation(); // Остановка происходящего
    event.preventDefault();  // Полная остановка происходящего
    // Создадим данные формы и добавим в них данные файлов из files
    var files = {
       'Task':{
           'img': document.getElementById("preview-img").src,
           'body': $('#modal-task-body').text(),
           'email': $('#exampleInputEmail1').val()
       }
    };
    $.ajax({
        type: "POST",
        data: files,
        url: '/site/task-create',
        success: function(data){
            $('#modal-window').removeClass('show');
            $('body').removeClass('modal-open');
            $('#modal-window').attr('aria-hidden','true');
            $('#modal-window').attr('style','display:none');
            $('body').removeAttr('style');
            $('.modal-backdrop').remove();
            $('#create-body').val('');
            $("#task-image").val('');
            $("#exampleInputEmail1").val('');
            $('#label-image-file').html('Choose image...');

            AddupdatePageLinks();
            closeModal();
        }
    });
});
function sorting(param) {
    var container = $('[sortname='+param+']');
    var sort = $(container).attr('sort');
    $.ajax({
        type: "GET",
        data: {
            sortname: param,
            sort:sort,
        },
        url: '/site/index',
        success: function(data){
            data = JSON.parse(data);
            updateTableBody(data['tasks']);
            addParameterToURL(sort,param);
            $(container).attr('sort',sort== 'ASC'?'DESC':'ASC');
            updatePAgeLInks(1);
        }
    });
}
function closeModal(){
    var text =  'Create task';
    $('#task-create').hide();
    $('#create-button').text(text);
}
function showModal(){
    var  text =  'Close the form';
    $('#task-create').show("slow");
    $('#create-button').text(text);
}
function AddupdatePageLinks(){
    $("#ct").load(location.href + " #ct");
    $("#tasktable-body").load(location.href + " #tasktable-body");
}
function updateTableBody(param){
    $('#tasktable-body').html(param);
}

function getPage(param){
    var container = $('[page='+param+']');
    var sortname =  container.attr('sortname');
    var sort   = container.attr('sort');
    var page = container.attr('page');
    var arr = {
        pageget:page
       }
    if(sortname)
        arr['sortname'] =  sortname;
    if(sort)
        arr['sort'] =  sort;

    $.ajax({
        type: "GET",
        data: arr,
        url: '/site/index',
        success: function(data){
            data = JSON.parse(data);
             updateTableBody(data['tasks']);
             if(sortname)
                addParameterToURL(sort,sortname);
            updatePAgeLInks(data['currentPage']);
        }
    });
}
function updatePAgeLInks(currentPage){
    var links = document.getElementsByClassName("db");
    $.each( links, function( i, val ) {
        page =  $(val).attr('page');
        sortContainer = $(val).attr('sort');
        if( page == currentPage)
            $(val).addClass('disabled');
        else
            $(val).removeClass('disabled');
    });
}
function addParameterToURL(sort,sortname){
    console.log(sort);
    var page;
    var links = document.getElementsByClassName("db");
    $.each( links, function( i, val ) {
        page =  $(val).attr('page');
        sortContainer = $(val).attr('sorts');
        if(!sortContainer){
            $(val).attr('sort',sort);
            $(val).attr('sortname',sortname);
        }else{
            $(val).removeAttr('sort');
            $(val).removeAttr('sortname');
            $(val).attr('sort',sort);
            $(val).attr('sortname',sortname);
        }
    });
}