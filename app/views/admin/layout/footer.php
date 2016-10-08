			</div>
        </div>
    </div>
    <div class="modal modal-click" id="test-modal">
	    <div class="modal-overlay"></div>
	    <div class="modal-container">
	        <div class="modal-header">
	            <button class="btn btn-clear float-right close-modal"></button>
	            <div class="modal-title">Modal title</div>
	        </div>
	        <div class="modal-body">
	            <div class="content">
	                <button class="btn btn-block" onclick="toast('测试消息提示!', 'error', '#test-modal .content');">toast</button>
	            </div>
	        </div>
	        <div class="modal-footer">
	            <button class="btn btn-link close-modal">Close</button>
	            <button class="btn btn-primary">Share</button>
	        </div>
	    </div>
	</div>
    <script type="text/javascript" src="<?php echo $this->assets('/app/assets/js/jquery-1.11.0.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo $this->assets('/app/assets/js/jquery.slimscroll.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo $this->assets('/app/assets/js/main.js'); ?>"></script>
</body>
</html>