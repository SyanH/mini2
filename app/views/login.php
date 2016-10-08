<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo $this->configs->charset; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>用户登陆</title>
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
						登陆
					</div>
					<div class="box-content">
						<div class="form-group">
                            <input class="form-input" id="name" type="text" placeholder="用户名/邮箱/手机号">
                        </div>
                        <div class="form-group">
                            <input class="form-input" id="password" type="password" placeholder="密码">
                        </div>
                        <div class="form-group clearfix">
                        	<div class="float-left">
                        		<label class="form-radio">
	                                <input type="checkbox" id="rememberMe">
	                                记住我
	                            </label>
                        	</div>
                        	<div class="float-right">
                        		<input type="button" class="btn btn-primary login-btn" value="登陆">
                        	</div>
                        </div>
                        <div class="form-group text-center">
                        	<a href="<?php echo $this->route('/reg'); ?>">注册账号</a> | 
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
			$('.login-btn').click(function(){
				var el = this;
				var name = $('#name').val();
				var password = $('#password').val();
				var rememberMe = $('#rememberMe').is(':checked') ? 1 : 0;
				if($.trim(name) == ''){
					toast('用户名不能为空', 'warning');
					return;
				}
				if($.trim(password) == ''){
					toast('密码不能为空', 'warning');
					return;
				}
				$.ajax({
					type: "POST",
					url: "<?php echo $this->route('/login'); ?>",
					data: {name:name, password:password, rememberMe:rememberMe},
					dataType: "json",
					beforeSend: function(){
						$(el).addClass('loading');
					},
					success: function(data){
						$(el).removeClass('loading');
						if (data.status == 1) {
							if(data.role == 'admin'){
								window.location.href = "<?php echo $this->route('/admin/index'); ?>";
							}else{
								window.location.href = "<?php echo $this->route(); ?>";
							}
						} else {
							toast('账号或密码不正确', 'error');
						}
					}
				});
			});

			$("body").keyup(function () {  
                if (event.which == 13){  
					$(".login-btn").trigger("click");  
                }
            });
		});
	</script>
</body>
</html>