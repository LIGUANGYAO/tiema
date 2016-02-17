/*
* 公共的表单验证方法
*/

//url格式验证
String.prototype.IsUrl = function() {
	var strRegex = "^((https|http|ftp|rtsp|mms)?://)" 
		+ "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@ 
		+ "(([0-9]{1,3}.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184 
		+ "|" // 允许IP和DOMAIN（域名）
		+ "([0-9a-z_!~*'()-]+.)*" // 域名- www. 
		+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]." // 二级域名 
		+ "[a-z]{2,6})" // first level domain- .com or .museum 
		+ "(:[0-9]{1,4})?" // 端口- :80 
		+ "((/?)|" // a slash isn't required if there is no file name 
		+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$"; 
	myReg = new RegExp(strRegex);//匹配url
	return myReg.test(this);
};

//邮箱验证
String.prototype.IsEmail = function() {
	var reg = /^[\w-+\.]+@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	return reg.test(this) && this.Len() <= 50;
};

//日期格式验证 
String.prototype.IsDate = function() {
	var myReg = /^(\d{4})(-|\/|.)(\d{1,2})\2(\d{1,2})$/;
	var result = this.match(myReg);
	if (result == null) return false;
	var test = new Date(result[1], result[3] - 1, result[4]);
	if ((test.getFullYear() == result[1]) && (test.getMonth() + 1 == result[3]) && (test.getDate() == result[4])) {
		ActRs.Clear();
		ActRs[0] = result[1];
		ActRs[1] = result[3];
		ActRs[2] = result[4];
		return true;
	}
	else return false;
};

String.prototype.IsTime = function() {
	var myReg = /^(\d{1,2})(:)(\d{1,2})\2(\d{1,2})$/;
	var result = this.match(myReg);
	if (result == null) return false;
	var test = new Date(2000, 1, 1, result[1], result[3], result[4]);
	if ((test.getHours() == result[1]) && (test.getMinutes() == result[3]) && (test.getSeconds() == result[4])) {
		ActRs[3] = result[1];
		ActRs[4] = result[3];
		ActRs[5] = result[4];
		return true;
	}
	else return false;
};
String.prototype.IsDateTime = function() {
	var myReg = this.split(" ");
	if (myReg.length != 2) return false;
	if (myReg[0].IsDate() && myReg[1].IsTime()) return true;
	return false;
};

//身份证号码验证
String.prototype.IsIdcard = function() {
	var myReg = /^[1-9][0-9]{14}$|^[1-9][0-9]{16}[0-9a-zA-Z]$/;
	if (myReg.test(this)) return true;
	return false;
};

//座机电话号码验证
String.prototype.IsTelephone = function() {
	var reg = /^((\d{2,5})[-]{0,1})?(\d{1,})(-(\d{3,}))?$/;
	return reg.test(this);
};

//手机号码验证 
String.prototype.IsPhone = function() {
	var reg = /^1[3,4,5,7,8]\d{9}$/ ;
	return reg.test(this);
};

//纯数字验证
String.prototype.IsNumber = function() {
	var myReg = /^[0-9]+$/;
	if (!myReg.test(this)) return false;
	ActRd = parseInt(this);
	return true;
};

//浮点数验证
String.prototype.IsFloat = function() {
	var myReg = /^[0-9.]+$/;
	if (!myReg.test(this)) return false;
	var pos = this.indexOf('.');
	if (pos == -1) return false;
	if (pos != this.lastIndexOf('.')) return false;
	if (pos == 0 || (pos + 1) == this.length) return false;
	ActRd = parseFloat(this);
	return true;
};

//qq号验证
String.prototype.IsQQ = function() {
	var reg = /^\d{5,11}$/;
	return reg.test(this);
};

//区号验证
String.prototype.IsAreacode = function(){
	var reg = /^\d{2,5}$/;
	return reg.test(this);
};
//7-8位电话号码验证
String.prototype.IsPhonecode = function(){
	var reg = /^\d{1,}$/;
	return reg.test(this);
};
//分机号验证
String.prototype.IsExtensioncode = function(){
	var reg = /^(\d{3,})?$/;
	return reg.test(this);
};

//邮政编码验证
String.prototype.Iszipcode = function(){
	var reg = /^[0-9]{3,6}$/;
	return reg.test(this);
};


//获取字符长度
String.prototype.Len = function() {
	var len = 0;
	for (var i = 0; i < this.length; i++) {
		if (this.charCodeAt(i) > 255) len += 2;
		else len++;
	}
	return len;
};

//判断金额2位
String.prototype.IsMoney = function(){
	var myReg=/^[0-9]*(\.[0-9]{1,2})?$/;
	return myReg.test(this);
}

//是否是姓名  中文且至少2个字
String.prototype.IsUsername = function(){
	var nameReg = /^[\u4e00-\u9fa5]+$/;
	return nameReg.test(this) && this.length >= 2;
}

//截取中英文字符串，如遇到中文截到一半，要截完整
String.prototype.subByte = function (start, bytes)
{
    for (var i=start; bytes>0; i++)
    {
        var code = this.charCodeAt(i);
        bytes -= code<256 ? 1 : 2;
    }
    return this.slice(start,i)
}

//支付宝账号判断，邮箱或者手机号
String.prototype.IsAlipayAccount = function(){
	return this.IsPhone() || this.IsEmail();
}
//获取时间
Date.prototype.format =function(format)
{
    var o = {
            "M+" : this.getMonth()+1, //month
            "d+" : this.getDate(), //day
            "h+" : this.getHours(), //hour
            "m+" : this.getMinutes(), //minute
            "s+" : this.getSeconds(), //second
            "q+" : Math.floor((this.getMonth()+3)/3), //quarter
            "S" : this.getMilliseconds() //millisecond
    };
    if(/(y+)/.test(format)) 
    {    
        format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4- RegExp.$1.length));
    }
    for(var k in o)
    {
        if(new RegExp("("+ k +")").test(format))
        {
            format = format.replace(RegExp.$1,RegExp.$1.length==1? o[k] :("00"+ o[k]).substr((""+ o[k]).length));
        }
    }
    return format;
};

