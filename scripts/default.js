function showToast(msg) {
    $('.notify-msg').html(msg);
    $('.notifier').show();
    setTimeout(() => {
        $('.notifier').hide();
    }, 2000);
}

function userRole(role) {
    switch (role) {
        case '0':
            return 'No Access';
        case '1':
            return 'Moderator';
        case '2':
            return 'Editor';
        case '3':
            return 'Administrator';
        case '5':
            return 'Super Admin';
        default:
            return 'No Access';
    }
}