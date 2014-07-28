$(document).ready(function () {
    // fancybox
    $(".fancybox").fancybox();
    // contributors
    $.ajax({
        type: 'GET',
        url: 'https://api.github.com/repos/cornernote/yii-account-module/contributors',
        dataType: 'json',
        success: function(result) {
            for(i in result) {
                $('#contributors ul').append('<li class="thumbnail"><a href="https://github.com/cornernote/yii-account-module/commits?author=' + result[i].login + '" target="_blank"><img src="' + result[i].avatar_url + 's=64" title="' + result[i].login + ' (' + result[i].contributions + ' contributions)"></a></li>');
            }
            $('#contributors h5').html(result.length + ' developer'+ (result.length>1 ? 's' : '') + ' contributed to this project:');
        }
    });
});