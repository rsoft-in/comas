function showToast(msg) {
    $('.notify-msg').html(msg);
    $('.notifier').show();
    setTimeout(() => {
        $('.notifier').hide();
    }, 2000);
}
