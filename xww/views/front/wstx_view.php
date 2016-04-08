<div class="content-main-wrap">
  <div class="content-right-wrap">
    <div style="height:400px;" class="yw-notice-wrap">
        <div class="col-xs-12" style="border-bottom:2px #cc0000 solid;">
          <h3 class="col-xs-8" style="padding-left:0;">Student Info</h3>
        </div>


          <div id="not-login">
            <p>You are Not Login,Please Login</p>
            <p>
              <div style="padding-left:20px;padding-right:20px;" class="form-group"><label>username</label><input id="username" class="form-control" type="text"  /></div>
              <div style="padding-left:20px;padding-right:20px;" class="form-group"><label>password</label><input id="password" class="form-control" type="text"  /></div>
              <input id="login" class="btn" type="button" value="login" /> 
              <input id="signin" class="btn" type="button" value="sign in" />
            </p>
          </div>
          <div style="display:none;" id="login">
            
          </div>

      </div>
  </div>


  <div class="content-wrap content-list-wrap">
      <div class="right-tit-wrap">
          <p><span class="ahead" >当前位置：<a href="<?php echo site_url(); ?>">首页</a> >> </span></p>
      </div>
      <ul id="wstxUl">  
         <li><i></i><a href="#"></a><span></span></li>
      </ul>
  </div>
</div>

<script>
  $(function(){

    $('#signin').on('click', function(){
      var input = $('input');
      var data = {
        username : input.eq(0).val(),
        passowrd : input.eq(1).val()
      }

      if(data['username'] == '' || data['passowrd'] == ''){
        alert('username or password is null');
      }else{
        $.post('<?php echo site_url('news/wstxSignin')?>', data, function(data)){
          console.log(data);
        }
      }
    });

    $('#login').on('click', function(){
      var input = $('input');
      var data = {
        username : input.eq(0).val(),
        password : input.eq(1).val()
      }

      if(data['username'] == '' || data['password'] == ''){
        alert('username or password is null');
      }else{
        $.post('<?php echo site_url('/news/wstxLogin') ?>', data, function(data){
          console.log(data);
        });
      }



    });

    var page = 0;
    $.post('<?php echo site_url('/news/wstxData') ?>', {page : page}, function(data){
      if(data){
        data = JSON.parse('['+data+']');
        data = data[0];
        console.log(data);
        var html = '';
        $(data).each(function(i, ele){
          html += '<li><i></i><a href="'+ele['news_id']+'">'+ele['title']+'</a><span></span></li>';
        });
        $('#wstxUl').html(html);
      }
    });
  });
</script>