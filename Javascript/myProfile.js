$(function ()
    {
        if ( window.history.replaceState )
            {
                window.history.replaceState( null, null, window.location.href );
            }


        $('#updatePassword1').on("change",function()
        {
            if($(this).val() === null)
                {
                    $('#updatePassword2').attr('disabled',true);
                }
            else
                {
                    $('#updatePassword2').removeAttr('disabled');
                }
        });
    });
