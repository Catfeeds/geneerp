/* global plus */

(function(mui, window, document, app) {
	//发送验证码全局变量
	window.curCount = 0;
	window.curCount = 0; //当前剩余秒数
	window.counts = 60; //间隔秒数
	window.InterValObj; //timer变量，控制时间
	//发送验证码倒计时函数
	app.sendSmsTime = function(o) {
		if(window.curCount === 0) {
			window.clearInterval(window.InterValObj); //停止计时器
			o.removeAttribute('disabled');
			o.innerText = '获取短信验证码';
		} else {
			window.curCount--;
			o.innerText = window.curCount + '秒后重新获取';
		}
	};

	/**
	 * 点击发送短信事件
	 * @param {String} mobile input 手机控件ID
	 * @param {String} captcha button 点击发送信息按钮ID
	 * @param {String} type 短信类型
	 */
	app.sendSmsTap = function(mobile, captcha, type) {
		var obj_mobile = app.get(mobile);
		var obj_captcha = app.get(captcha);
		obj_captcha.addEventListener('tap',
			function() {
				if(!app.checkMobile(obj_mobile.value)) {
					mui.toast('手机号格式错误');
					return false;
				}
				var wd = plus.nativeUI.showWaiting();
				mui.post(app.api.smsCaptcha, {
					mobile: obj_mobile.value,
					type: type
				}, function(data) {
					wd.close(); //调用成功，先关闭等待的对话框  
					if(data.success === 1) {
						mui.toast('发送成功');
						//开始计时
						window.curCount = window.counts;
						window.InterValObj = window.setInterval(function() {
							obj_captcha.setAttribute('disabled', true);
							app.sendSmsTime(obj_captcha);
						}, 1000);
					} else {
						obj_captcha.removeAttribute('disabled');
						mui.toast(data.message);
					}
				}, 'json');

			}, false);
	};

	//全局API接口
	//app.apiUrl = 'http://api.jjcms.com/v1/';
	app.apiUrl = 'http://192.168.1.22/geneerp/api/web/v1/';

	app.api = {
		userLogin: app.apiUrl + 'user/login', //用户登录
		userRegister: app.apiUrl + 'user/register', //用户注册
		smsCaptcha: app.apiUrl + 'user/sms-captcha', //获取手机验证码
		forgetPassword: app.apiUrl + 'user/forget-password', //忘记密码
		uploadHead: app.apiUrl + 'user/upload-head', //上传头像
		updateProfile: app.apiUrl + 'user/update-profile', //更新用户资料
		contentList: app.apiUrl + 'content/content-list', //信息列表
		contentDetail: app.apiUrl + 'content/content-detail', //信息详情
	};

	app.userStatus = function() {
		mui.fire(app.view('my.html'), 'userStatus');
		mui.fire(app.view('profile.html'), 'userStatus');
	};

	app.userSet = function(data, updateToken) {
		//console.log(JSON.stringify(data));
		if(updateToken === true) {
			localStorage.setItem('token', data.token);
			localStorage.setItem('mobile', data.mobile);
			localStorage.setItem('username', data.username);
			//localStorage.setItem('userhead', data.userhead);
			localStorage.setItem('userpoint', data.userpoint);
			localStorage.setItem('userregister', data.userregister);
		}
		//更新资料
		localStorage.setItem('userbirthday', data.userbirthday);
		localStorage.setItem('userarea', data.userarea);
		localStorage.setItem('userarea_id', data.userarea_id);
		localStorage.setItem('usersign', data.usersign);
	}

	//打印所有page
	app.pointView = function() {
		mui.each(plus.webview.all(), function(index, item) {
			console.log(item.id);
		});
	};

	app.get = function(id) {
		return document.getElementById(id);
	};

	app.selector = function(selector) {
		return document.querySelector(selector);
	};
	app.view = function(id) {
		return plus.webview.getWebviewById(id);
	};
	app.close = function(id) {
		return plus.webview.close(id);
	};
	app.tap = function(ids, callFunction) {
		if(Array.isArray(ids)) {
			mui.each(ids, function(index, id) {
				app.get(id).addEventListener('tap', callFunction, false);
			});
		} else {
			app.get(ids).addEventListener('tap', callFunction, false);
		}
	};

	app.events = function(event, callFunction) {
		window.addEventListener(event, callFunction);
	};

	app.open = function(page) {
		mui.openWindow({
			url: page,
			id: page
		});
	};

	app.checkMobile = function(mobile_value) {
		if((/^1[34578]\d{9}$/.test(mobile_value))) {
			return true;
		}
		return false;
	};

	/**********************上传图片相关**********************/

	/**
	 * 将图片压缩转成base64
	 * @param {Object} img 图片
	 * @param {Object} size 最大尺寸
	 */
	app.getBase64Image = function(img, maxSize) {
		var canvas = document.createElement('canvas');
		var width = img.width;
		var height = img.height;
		if(width > height) {
			if(width > maxSize) {
				height = Math.round(height *= maxSize / width);
				width = maxSize;
			}
		} else {
			if(height > maxSize) {
				width = Math.round(width *= maxSize / height);
				height = maxSize;
			}
		}
		canvas.width = width; /*设置新的图片的宽度*/
		canvas.height = height; /*设置新的图片的长度*/
		var ctx = canvas.getContext('2d');
		ctx.drawImage(img, 0, 0, width, height); /*绘图*/

		var dataURL = canvas.toDataURL('image/png', 1);
		return dataURL.replace('data:image/png;base64,', '');
	};

	/**********************分享相关**********************/

	/**
	 * 更新分享服务
	 */
	app.updateSerivces = function() {
		plus.share.getServices(function(s) {
			shares = {};
			for(var i in s) {
				var t = s[i];
				shares[t.id] = t;
			}
			console.log("获取分享服务列表成功");
		}, function(e) {
			console.log("获取分享服务列表失败：" + e.message);
		});
	};
	/**
	 * 分享操作
	 */
	app.shareAction = function(id, ex, callFunction) {
		console.log('id = ' + id);
		console.log('ex = ' + ex);
		console.log('shares[id]' + shares[id]);
		var s = null;
		if(!id || !(s = shares[id])) {
			console.log("无效的分享服务！");
			return;
		}
		if(s.authenticated) {
			console.log("---已授权---");
			callFunction(s, ex);
		} else {
			console.log("---未授权---");
			s.authorize(function() {
				callFunction(s, ex);
			}, function(e) {
				console.log("认证授权失败");
			});
		}
	};

	/**
	 * 分享按钮点击事件
	 * 注意这里的这些id值
	 */
	app.shareHref = function(callFunction) {
		var ids = [{
				id: "weixin",
				ex: "WXSceneSession" /*微信好友*/
			}, {
				id: "weixin",
				ex: "WXSceneTimeline" /*微信朋友圈*/
			}, {
				id: "qq" /*QQ好友*/
			}, {
				id: "tencentweibo" /*腾讯微博*/
			}, {
				id: "sinaweibo" /*新浪微博*/
			}],
			bts = [{
				title: "发送给微信好友"
			}, {
				title: "分享到微信朋友圈"
			}, {
				title: "分享到QQ"
			}, {
				title: "分享到腾讯微博"
			}, {
				title: "分享到新浪微博"
			}];
		plus.nativeUI.actionSheet({
				cancel: "取消",
				buttons: bts
			},
			function(e) {
				var i = e.index;
				console.log('i = ' + i);
				if(i > 0) {
					app.shareAction(ids[i - 1].id, ids[i - 1].ex, callFunction);
				}
			}
		);
	};
}(mui, window, document, window.app = {}));