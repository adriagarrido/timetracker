$(document).ready(function () {
    var running = false;

    $('#btn-startstop').click(function() {
        startstop();
    });
    $('#input-task').keyup(function(e){
        if(e.keyCode == 13) {
            startstop();
        }
    });
    $("form").submit(function(e){
        e.preventDefault();
    });

    function startstop() {
        if ($('#input-task').val() == '') {return;}
        $('#btn-startstop').toggleClass('btn-danger', 'btn-success');
        $('#btn-value').toggleClass('fa-stop', 'fa-play');
        if (running == true) {
            final = new Date();
            clearInterval(control);
            running = false;
            saveToDb($('#input-task').val(), $('#hidden-id').val());
            $('#input-task').val('');
            $('#screen').html('0:00:00');
        } else {
            inicial = new Date();
            control = setInterval(cronometro,10);
            running = true;
            result  = saveToDb($('#input-task').val());
        }
        $('#input-task').prop('disabled', running);
    }

    // Basado en el crono de Romlonix
    // https://codepen.io/Romlonix/pen/Fwsza
    function cronometro () {
        current = new Date();
        crono = new Date();
        crono.setTime(current - inicial);
        ss = crono.getSeconds();
        mm = crono.getMinutes();
        hh = crono.getHours() - 1;
        if (ss < 10) {ss = "0"+ss;} 
        if (mm < 10) {mm = "0"+mm;}
        $('#screen').html(hh + ':' + mm + ':' + ss);
    }

    function reset() {
        clearInterval(control);
        running = false;
        $('#input-task').val('');
        $('#screen').html('0:00:00');
        $('#input-task').prop('disabled', running);
    }

    function saveToDb($task, $id) {
        $url = BASE_URL + '/tasks/save';
        $.ajax({
            method: "POST",
            url: $url,
            data: { task: $task, id: $id }
        })
        .fail(function( textStatus ) {
            console.log( "Request failed: " + textStatus );
            reset();
        })
        .done(function( msg ) {
            $('#hidden-id').val(msg);
            if ( $id != undefined && msg != undefined) {
                updateTasks();
            }
        });
    }

    function updateTasks() {
        $.ajax({
            method: "POST",
            url: BASE_URL + '/tasks/gettasks',
        })
        .fail(function( textStatus ) {
            console.log( "Request failed: " + textStatus );
        })
        .done(function( msg ) {
            $('#tasks-list').html(msg)
        });
    }
});