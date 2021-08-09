@if (auth()->guard()->check() == true)
<script>
    function totalNotif() {
        $.ajax({
            url : "/admin/notification/api",
            type : "GET",
            dataType : "json",
            data : {},
            success:function(data) {
            if (data.total > 0) {
                var html = data.total + ' @lang('mod/setting.notification.new_notif')';
            } else {
                var html = '@lang('mod/setting.notification.caption')';
            }

            $('#count-new-notif').html(html);
                if (data.total > 0) {
                    $('#notif-dot').css({
                        display : 'inline block'
                    });
                    $('.count-dot').html(data.total);
                } else {
                    $('#notif-dot').css({
                        display : 'none'
                    });
                }
                setTimeout(totalNotif, 60 * 1000);
            }
        })
    };

    $(document).ready(function() {
        totalNotif();
    });

    $('#click-notif').click(function () {
        $.ajax({
            url : "/admin/notification/api",
            type : "GET",
            dataType : "json",
            data : {},
            success:function(data) {
                $('#list-notification').html(' ');
                if (data.latest.length > 0) {
                    $.each(data.latest ,function(index, value) {
                        var titik = '';
                        if (value.title.length > 35) {
                            titik = '...';
                        }
                        if (value.content.length > 35) {
                            titik = '...';
                        }
                        $('#list-notification').append(`
                        <a href="{{ url('/') }}/`+value.link+`notif_id=`+value.id+`" class="list-group-item list-group-item-action media d-flex align-items-center">
                            <div class="ui-icon ui-icon-sm `+value.icon+` bg-`+value.color+` border-0 text-white"></div>
                                <div class="media-body line-height-condenced ml-3">
                                <div class="text-body">`+value.title.substring(0, 35)+titik+`</div>
                                    <div class="text-light small mt-1">
                                        `+value.content.substring(0, 35)+titik+`
                                    </div>
                                <div class="text-light small mt-1">`+value.date+`</div>
                            </div>
                        </a>
                        `);
                    });
                } else {
                    $('#list-notification').html(`
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action media text-center">
                            <i><strong style="color:red;">! @lang('mod/setting.notification.no_notif') !</strong></i>
                        </a>
                    `);
                }
            },
        });
    });
</script>
@endif