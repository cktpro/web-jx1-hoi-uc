var returnURL = '/';
function ajaxLogin() {
  var username = $("#login_username").val();
  var password = $("#login_password").val();
  if (!username) {
    $("#login_msg").addClass("text-danger ").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhập tên đăng nhập');
    $("#login_username").focus();
  } else if (!password) {
    $("#login_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhập mật khẩu');
    $("#login_password").focus();
  }
  else
  {
    $.post('/api/users/AjaxLogin.php', {password:password,username:username,}, function (result){
        if(result.status){
          $("#login_msg").html('<i class="fa fa-check" aria-hidden="true"></i>  Đăng nhập thành công!').removeClass("text-danger").addClass("text-success");
          setTimeout(function(){
            window.location.href = returnURL;
          }, 1000);
        }
        else{
          $("#login_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> '+result.msg);
        }
      },
      'JSON'
    );
  }
}
function ajaxRegister() {
  var username = $("#register_username").val();
  var password = $("#register_password").val();
  var rePassword = $("#register_rePassword").val();
  if (!username) {
    $("#register_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhập tên tài khoản');

    $("#register_username").focus();
  }else if (!password) {
    $("#register_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhận mật khẩu');
    $("#register_password").focus();
  }
  else if (!rePassword) {
    $("#register_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> Vui xác nhập mật khẩu');
    $("#register_rePassword").focus();
  }else if(password != rePassword){
    $("#register_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> Xác nhận mật khẩu không chính xác');
  }

  else
  {
    $.post('/api/users/AjaxRegister.php', {password:password,username:username,rePassword:rePassword, referrer: referrer}, function (result){
        if(result.status){
          $("#register_msg").html('<i class="fa fa-check" aria-hidden="true"></i> Đăng kí thành công!').removeClass("text-danger").addClass("text-success");
          setTimeout(function(){
            window.location.href = '/';
          }, 1000);
        }
        else{
          $("#register_msg").addClass("text-danger").html('<i class="fa fa-close" aria-hidden="true"></i> '+result.msg);
        }
      },
      'JSON'
    );
  }
}
function getNews(type){
    $( ".showArticle" ).empty();
    $.get( "/api/getArticle.php?type=" + type, function( data ) {
      $( ".showArticle" ).html( data );
          });

}
jQuery(document).ready(function(){
  getNews('all');
  });
