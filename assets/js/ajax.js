function showAllTransaction(){  //sidebar
    $.ajax({
        url:"./adminViews/allTransaction.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}

function showAllAnnouncement(){  //sidebar
    $.ajax({
        url:"./adminViews/announcement.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}

function showMap(){  //sidebar
    $.ajax({
        url:"./adminViews/map.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}


function showAllAdminRecord(){  //sidebar
    $.ajax({
        url:"./adminViews/AdminAccountRecord.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}

function showAllOwnerRecord(){  //sidebar
    $.ajax({
        url:"./adminViews/OwnerAccountRecord.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}


function showAllAddAccount(){  //add account in Account records
    $.ajax({
        url:"/adminViews/AddAdminAccount.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.accountContent').html(data);
        }
    });
}

function showmessage(){  //sidebar
    $.ajax({
        url:"./adminViews/sendmail.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}

function showMessage(){  //sidebar
    $.ajax({
        url:"homeownerViews/homeownerMessage.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent').html(data);
        }
    });
}