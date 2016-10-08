<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo $this->configs->charset; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理</title>
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/normalize.css'); ?>" />
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/base.css'); ?>" />
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/style.css'); ?>" />
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/helper.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->assets('/app/assets/css/pe-icon-7-stroke.css'); ?>">
</head>
<body>
    <div class="container rel">
        <div class="sidebar">
        	<div class="sidebar-wrap">
	        	<div class="logo">
	        		<a href="<?php echo $this->route('/admin/index'); ?>"><i class="pe-7s-sun"></i></a>
	        	</div>
	        	<nav class="nav">
	        		<ul class="clean-ul">
	        			<li><a href="javascript:void(0)"><i class="icon pe-7s-home"></i>控制台</a></li>
	        			<ul class="clean-ul">
							<li><a href="<?php echo $this->route('/admin/index'); ?>">后台首页</a></li>
							<li><a href="<?php echo $this->route(); ?>">前台首页</a></li>
						</ul>
	        			<!-- <li><a href="javascript:void(0)"><i class="icon pe-7s-plugin"></i>模型</a></li> -->
	        			<li><a href="javascript:void(0)"><i class="icon pe-7s-box1"></i>栏目</a></li>
	        			<ul class="clean-ul">
							<li><a href="#">二级菜单1</a></li>
							<li class="current"><a href="#">二级菜单2</a></li>
							<li><a href="#">二级菜单3</a></li>
							<li><a href="#">二级菜单4</a></li>
						</ul>
	        			<li><a href="javascript:void(0)"><i class="icon pe-7s-news-paper"></i>内容</a></li>
	        			<ul class="clean-ul">
							<li><a href="#">二级菜单1</a></li>
							<li class="current"><a href="#">二级菜单2</a></li>
							<li><a href="#">二级菜单3</a></li>
							<li><a href="#">二级菜单4</a></li>
						</ul>
	        			<li><a href="javascript:void(0)"><i class="icon pe-7s-users"></i>用户</a></li>
	        			<li><a href="javascript:void(0)"><i class="icon pe-7s-plug"></i>扩展</a></li>
	        			<li><a href="javascript:void(0)"><i class="icon pe-7s-config"></i>设置</a></li>
	        			<ul class="clean-ul">
							<li><a href="<?php echo $this->route('/admin/option'); ?>">站点设置</a></li>
						</ul>
	        		</ul>
	        	</nav>
	        	<div class="search">
	        		<input type="text" class="search-input" spellcheck="false" placeholder="搜索">
	        		<i class="icon pe-7s-search"></i>
	        	</div>
        	</div>
        </div>
        <div class="main">
        	<div class="main-wrap">
        		<!-- main header -->
        		<div class="main-header light-shadow">
        			<div class="columns col-gapless">
        				<div class="column col-7 reset-padding">
        					<h5 class="main-title reset-margin">
        						<?php echo isset($mainTitle) ? $mainTitle : '控制台' ; ?>
        					</h5>
        				</div>
        				<div class="column col-5 reset-padding">
        					<div class="main-header-link text-right">
        						<figure class="avatar">
			                        <img src="<?php echo $this->assets('/app/assets/images/avatar-1.png'); ?>" />
			                    </figure>
			                    <a href="<?php echo $this->route('/logout'); ?>" class="btn btn-link">退出</a>
        					</div>
        				</div>
        			</div>
        		</div>
				<!-- main header end -->