$(document).ready(function() {

    $('body').on('click','.btn-file-delete',function(e){
        e.preventDefault();
        console.log('.btn-file-delete');
        var $this = $(this);
        var target = $this.attr('href');
        console.log(target);

        $.ajax({
            type: 'POST',
            url: target,
            //data: data,
            dataType : 'json',
            success: function(data){
                console.log(data);
                $(".file_item_"+data.id).remove();
                $(".close").trigger( "click" );
                /*
                $('.modal').modal('hide')
                $('.modal').hide();
                $('.modal-backdrop').hide();
                */
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.status);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });

    });

    $('body').on('click','.search_close',function(e){
        e.preventDefault();
        $(".search-wrapper").removeClass("active");
    });


    //showing date
    showDate();
});

function showDate() {
    var now = new Date();
    $('.date_info').each(function( index ) {
        var $this = $(this);

        var time = now.getTime() - (parseInt($this.attr('data-s')) * 1000);
        var date = new Date(time);

        var format = "";
        if (typeof $this.attr('data-format') !== 'undefined') {
            format = $this.attr('data-format');
        }
        $this.html(getDateLabel(date, format));
    });
}

function getDateLabel(date, format='') {
    var label = "";

    var jours = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
    var mois = new Array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");

    if(format == "dd/mm/YYYY H:i"){
        //day in month
        label += (parseInt(date.getDate()) < 10 ? '0' : '') + parseInt(date.getDate());
        //month
        label += "/"+(parseInt(date.getMonth()+1) < 10 ? '0' : '') + parseInt(date.getMonth()+1);
        //year
        label += "/"+date.getFullYear();
        //hours
        label += " "+(parseInt(date.getHours()) < 10 ? '0' : '') + parseInt(date.getHours());
        //minutes
        label += ":"+(parseInt(date.getMinutes()) < 10 ? '0' : '') + parseInt(date.getMinutes());
    }else{
        //label day
        label += jours[date.getDay()];
        //day in month
        label += " "+(parseInt(date.getDate()) < 10 ? '0' : '') + parseInt(date.getDate());
        //month
        label += " "+mois[date.getMonth()];
        //year
        label += " "+date.getFullYear();
        label += " à";
        //hours
        label += " "+(parseInt(date.getHours()) < 10 ? '0' : '') + parseInt(date.getHours());
        //minutes
        label += ":"+(parseInt(date.getMinutes()) < 10 ? '0' : '') + parseInt(date.getMinutes());
    }

    return label;
}