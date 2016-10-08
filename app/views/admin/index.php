<!-- main content -->
<div class="main-content">
	<div class="box light-shadow">
		<div class="box-title">
			主要组件
		</div>
		<div class="box-content">
			<ul class="tab">
                <li class="tab-item active">
                    <a href="#a">form</a>
                </li>
                <li class="tab-item">
                    <a href="#b">table</a>
                </li>
                <li class="tab-item">
                    <a href="#c">grid</a>
                </li>
                <li class="tab-item">
                    <a href="#d">modal</a>
                </li>
            </ul>
            <div class="tab-content">
            	<div class="tab-content-item active" id="a">
            		<form action="">
            			<div class="form-group">
                            <label class="form-label" for="input-example-1">标题</label>
                            <input class="form-input" type="text" id="input-example-1" placeholder="标题">
                        </div>
                        <div class="form-group form-group-block">
                            <label class="form-label">radio block</label>
                            <label class="form-radio">
                                <input type="radio" name="gender">
                                选项1
                            </label>
                            <label class="form-radio">
                                <input type="radio" name="gender">
                                选项2
                            </label>
                            <label class="form-radio">
                                <input type="radio" name="gender" checked>
                                选项3
                            </label>
                        </div>
                        <div class="form-group">
                        	<label class="form-label">radio inline</label>
                            <label class="form-radio">
                                <input type="radio" name="gender">
                                选项1
                            </label>
                            <label class="form-radio">
                                <input type="radio" name="gender">
                                选项2
                            </label>
                            <label class="form-radio">
                                <input type="radio" name="gender" checked>
                                选项3
                            </label>
                        </div>
                        <div class="form-group form-group-block">
                        	<label class="form-label">checkbox block</label>
                        	<label class="form-checkbox">
                                <input type="checkbox">
                             	选项1
                            </label>
                            <label class="form-checkbox">
                                <input type="checkbox" checked>
                             	选项2
                            </label>
                        </div>
                        <div class="form-group">
                        	<label class="form-label">checkbox inline</label>
                        	<label class="form-checkbox">
                                <input type="checkbox">
                             	选项1
                            </label>
                            <label class="form-checkbox">
                                <input type="checkbox" checked>
                             	选项2
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input-example-3">内容</label>
                            <textarea class="form-input" id="input-example-3" spellcheck="false" placeholder="Textarea" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">http://</span>
                                <input type="text" class="form-input" placeholder="site url" />
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <button class="btn btn-link" type="reset">Cancel</button>
                        </div>
            		</form>
            	</div>
            	<div class="tab-content-item" id="b">
            		<table class="table table-striped table-hover mt-10 checkbox-all-wrap">
	                    <thead>
	                        <tr>
	                            <th><input type="checkbox" class="checkbox-all"></th>
	                            <th>标题</th>
	                            <th>时间</th>
	                            <th>作者</th>
	                            <th>更新</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr>
	                            <td><input type="checkbox"></td>
	                            <td>The Shawshank Redemption</td>
	                            <td>2h 22min</td>
	                            <td>Crime, Drama</td>
	                            <td>14 October 1994 <span class="label">USA</span></td>
	                        </tr>
	                        <tr>
	                            <td><input type="checkbox"></td>
	                            <td>The Godfather</td>
	                            <td>2h 55min</td>
	                            <td>Crime, Drama</td>
	                            <td>24 March 1972 <span class="label">USA</span></td>
	                        </tr>
	                        <tr>
	                            <td><input type="checkbox"></td>
	                            <td>Schindler's List</td>
	                            <td>3h 15min</td>
	                            <td>Biography, Drama, History</td>
	                            <td>4 February 1994 <span class="label">USA</span></td>
	                        </tr>
	                        <tr>
	                            <td><input type="checkbox"></td>
	                            <td>Se7en</td>
	                            <td>2h 7min</td>
	                            <td>Crime, Drama, Mystery</td>
	                            <td>24 March 1972 <span class="label label-primary">USA</span></td>
	                        </tr>
	                    </tbody>
	                </table>
	                <ul class="pagination text-center">
					    <li class="page-item">
					        <a href="#" class="disabled">
					            Previous
					        </a>
					    </li>
					    <li class="page-item active">
					        <a href="#">
					            1
					        </a>
					    </li>
					    <li class="page-item">
					        <a href="#">
					            2
					        </a>
					    </li>
					    <li class="page-item">
					        <a href="#">
					            3
					        </a>
					    </li>
					    <li class="page-item">
					        <span>...</span>
					    </li>
					    <li class="page-item">
					        <a href="#">
					            12
					        </a>
					    </li>
					    <li class="page-item">
					        <a href="#">
					            Next
					        </a>
					    </li>
					</ul>
            	</div>
            	<div class="tab-content-item" id="c">
            		<div class="container">
					    <div class="columns">
					        <div class="column col-6">
					        	<div style="background-color: #dfdfdf;padding:20px;text-align: center;">col-6</div>
					        </div>
					        <div class="column col-3">
					        	<div style="background-color: #dfdfdf;padding:20px;text-align: center;">col-3</div>
					        </div>
					        <div class="column col-3">
					        	<div style="background-color: #dfdfdf;padding:20px;text-align: center;">col-3</div>
					        </div>
					    </div>

					    <div class="columns">
					        <div class="column col-6">
					        	<div style="background-color: #dfdfdf;padding:20px;text-align: center;">col-6</div>
					        </div>
					        <div class="column col-6">
					        	<div style="background-color: #dfdfdf;padding:20px;text-align: center;">col-6</div>
					        </div>
					    </div>
					</div>
            	</div>
            	<div class="tab-content-item" id="d">
            		<a modal-href="#test-modal" modal class="btn btn-primary">modal</a>
            		<a modal-href="<?php echo $this->route('admin/index/modal'); ?>" modal class="btn btn-primary">modal ajax</a>
            	</div>
            </div>
		</div>
	</div>
	<div class="columns">
		<div class="column col-6">
			<div class="box light-shadow mt-10">
				<div class="box-title">
					按钮组
				</div>
				<div class="box-content">
					<div class="btn-group btn-group-block">
	                    <button class="btn active">按钮1</button>
	                    <button class="btn">按钮2</button>
	                    <button class="btn">按钮3</button>
	                </div>
	                <div class="mt-10">
	                	<button class="btn btn-primary">单个按钮</button>
	                	<button class="btn btn-primary active">单个按钮</button>
	                	<button class="btn loading">加载</button>
	                </div>
	                <div class="mt-10">
	                	<button class="btn btn-block" onclick="toast('测试消息提示!', 'error');">toast</button>
	                </div>
				</div>
			</div>
			<div class="box light-shadow mt-20">
				<div class="box-title">
					头像
				</div>
				<div class="box-content">
					<div class="mt-10">
	                    <figure class="avatar avatar-xl">
	                        <img src="<?php echo $this->assets('/app/assets/images/avatar-1.png'); ?>" />
	                    </figure>
	                    <figure class="avatar avatar-xl">
	                        <img src="<?php echo $this->assets('/app/assets/images/avatar-1.png'); ?>" />
	                        <img src="<?php echo $this->assets('/app/assets/images/avatar-1.png'); ?>" class="avatar-icon" />
	                    </figure>
	                    <figure class="avatar avatar-xl" data-initial="Syan" style="background-color: #39dd92;"></figure>
	                </div>
				</div>
			</div>
		</div>
		<div class="column col-6">
			<div class="box light-shadow mt-10">
				<div class="box-title">
					消息提示
				</div>
				<div class="box-content">
					<div class="toast mt-10">
	                    <button class="btn btn-clear float-right"></button>
	                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
	                </div>

	                <div class="toast toast-error mt-10">
	                    <button class="btn btn-clear float-right"></button>
	                    <span class="icon icon-error_outline"></span>
	                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
	                </div>
	                <div class="toast toast-success mt-10">
	                    <button class="btn btn-clear float-right"></button>
	                    <span class="icon icon-error_outline"></span>
	                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
	                </div>
	                <div class="toast toast-warning mt-10">
	                    <button class="btn btn-clear float-right"></button>
	                    <span class="icon icon-error_outline"></span>
	                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
	                </div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- main-content end -->