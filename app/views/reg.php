<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo $this->configs->charset; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>账号注册</title>
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/normalize.css'); ?>" />
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/base.css'); ?>" />
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/helper.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/pe-icon-7-stroke.css'); ?>">
</head>
<body>
    <div class="container rel">
    	<div class="columns">
    		<div class="column col-5 centered main-content">
    			<div class="box light-shadow" style="margin-top:100px;">
    				<div class="box-title">
						注册
					</div>
					<div class="box-content">
						<div class="form-group">
                            <input class="form-input" id="name" type="text" placeholder="用户名">
                        </div>
                        <div class="form-group">
                            <input class="form-input" id="email" type="text" placeholder="邮箱">
                        </div>
                        <div class="form-group">
                            <input class="form-input" id="password" type="password" placeholder="密码">
                        </div>
                        <div class="form-group">
                            <input class="form-input" id="enpassword" type="password" placeholder="确认密码">
                        </div>
                        <div class="form-group">
                    		<input type="button" class="btn btn-primary btn-block reg-btn" value="注册">
                        </div>
                        <div class="form-group text-center">
                        	<a href="<?php echo $this->route('/login'); ?>">登陆后台</a> | 
                        	<a href="<?php echo $this->route(); ?>">返回首页</a>
                        </div>
					</div>
    			</div>
    		</div>
    	</div>
    </div>
	<script type="text/javascript" src="<?php echo $this->assets('/app/assets/js/jquery-1.11.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo $this->assets('/app/assets/js/jquery.slimscroll.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo $this->assets('/app/assets/js/main.js'); ?>"></script>
    <script type="text/javascript">
		$(function(){
			$('.reg-btn').click(function(){
				var el = this;
				var name = $.trim($('#name').val());
				var email = $.trim($('#email').val());
				var password = $.trim($('#password').val());
				var enpassword = $.trim($('#enpassword').val());
				if(name == ''){
					toast('用户名不能为空', 'warning');
					return;
				}
				if(email == ''){
					toast('邮箱不能为空', 'warning');
					return;
				}
				if(password == ''){
					toast('密码不能为空', 'warning');
					return;
				}
				if(enpassword == ''){
					toast('确认密码不能为空', 'warning');
					return;
				}
				$.ajax({
					type: "POST",
					url: "<?php echo $this->route('/reg'); ?>",
					data: {name:name, password:password, email:email, enpassword:enpassword},
					dataType: "json",
					beforeSend: function(){
						$(el).addClass('loading');
					},
					success: function(data){
						$(el).removeClass('loading');
						if (data.status == 1) {
							$('#name, #email, #password, #enpassword').val('');
                            toast(data.msg, 'success');
						} else if(data.status == -1) {
                            toast(data.msg, 'error');
						}
					}
				});
			});

		});
	</script>
</body>
</html>