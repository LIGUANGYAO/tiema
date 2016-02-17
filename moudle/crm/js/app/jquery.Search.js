/*
 * SimpleModal 1.2.3 - jQuery Plugin
 * http://www.sameus.com/ 豫ICP备12014277号
 * duzhengting Copyright (c) 
 * Dual licensed under the MIT and GPL licenses
 * Revision: $Id: jquery.Search.js 185 2012-09-12 12:51:12Z emartin24 $
 */
;(function($){
	$.fn.extend({
		"searchs":function(opts){
                    var opts =$.extend({}, {
                        durl: 'data.php',/*数据传送链接*/
                        surl:'search.php',/*搜素链接*/
                        ul_id:'Box_search_ul',/*添加的ul命名*/
                        bgcolor:{'margin':'0px','padding':'0px','line-height':'20px','background':'none repeat scroll 0 0 #ffffff','color':'#CCC','border':'1px solid #DDDDDD','overflow':'hidden','position': 'absolute'},
                        acolor: {'background-color':'red'},/*生成li标签css设置*/
                        name:'data',/**获取数据名字**/
                        send_data:true,
                        local_data:{},
                       _return:function(result){/*当if_send设置为true时有效*/
                          var dts; 
                          if( result.status == 1){
                              dts = result.data;
                              for( var x in dts ){  
                                 $('#'+opts.ul_id).append('<li style="list-style:none;"><a href="'+opts.surl+'&data='+dts[x]+'">'+dts[x]+'</a></li>');
                              } 
                        }else{    
                             $('#'+opts.ul_id).hide(); 
                             return this;
                           } 
                       }
                    }, opts);
					
                    /**按键上下 判断移动**/
                    $(this).bind('keyup',function(event){
                       var e_key= event.keyCode; 
                       var os,ldata,_box;
                      var thisdt=$(this).val();
                       if($(this).val() == ''){
                            $('#'+opts.ul_id).hide();
                            return this; 
                       }else if($('#'+opts.ul_id).size() == 0){
                          $(this).after('<ul id="'+opts.ul_id+'" ></ul>');
                       }
                       _box=$('#'+opts.ul_id);
                      // os= $(this).offset(); 
                       _box.offset({left:$(this).left,top:$(this).top+$(this).height()}); 
                       _box.css('width',$(this).width()+8);
                       /*鼠标点击*/
                        if(e_key == 13){ 
                           if( $(this).val() != '' ){ 
                                window.location=_box.find('.selected').find('a').attr('href') ; 
                           }  
                       }else if(e_key != 40 && e_key != 38 ){ 
                               _box.html(''); 
                               _box.show(); 
                              
                                for(var w in opts.bgcolor){
                                     _box.css(w,opts.bgcolor[w]);
                                };
                                /*判断是否需要从后台调取数据,并根据调取数据方式相应处理*/
                                if(opts.send_data == true){ 
                                  
                                    $.post(opts.durl,{'data':$(this).val()},function( rst ){   
                                         $('#'+opts.ul_id).append('<li style="list-style:none;" class="selected"><a href="'+opts.surl+'&data='+thisdt+'">'+thisdt+'</a></li>');
                                         opts._return(rst);   
                                        },'json'); 
                                }else{
                                    var ldata=opts.local_data;
                                    for( var x in ldata){  
                                       $('#'+opts.ul_id).append('<li style="list-style:none;width:100%;"><a  href="'+ opts.surl+'&kind='+x+'&'+opts.name+'='+$(this).val()+'">'+ldata[x]+$(this).val()+'</a></li>');
                                    }
                                } 
                                if(_box.find('li').size()<0){
                                     _box.hide(); 
                                     return this;
                                };
                                 /*为box内li添加属性*/
                              ///   _box.prepend('<li style="display:none;">'+$(this).val()+'</a></li>');  
                                 _box.find('li:eq(0)').addClass('selected'); 
                       }else{ 
                           var b_l=_box.find('li').size()-1; 
                           for(var i=0;i <= b_l; i++){  
                               if(_box.find('li:eq('+i+')').hasClass('selected')==true){
                                   
                                  _box.find('li:eq('+i+')').removeClass('selected'); 
                                    /**以下顺序不可变更**/
                                    switch(e_key){ 
                                        case 40:
                                             i ==  b_l ? i = 0: i = i*1+1; 
                                            break;
                                        case 38:
                                            i == 0 ? i = b_l : i = i-1;
                                            break;
                                    } 
                                   _box.find('li:eq('+i+')').addClass('selected');
                                   if(opts.send_data == true){ 
                                     $(this).val($('.selected').text());
                                   }
                                  return this;
                              }
                           }
							
                       }
                    })
                    /*延迟时间执行blur,以备鼠标点击按钮可选*/
                   $(this).blur(function (){
                         setTimeout(function(){
                              $('#'+opts.ul_id).hide()  ;
                         }, 260);
                   })
                   $(this).focus(function (){
                        $('#'+opts.ul_id).show();
                   }) 
		}
                
	});
})(jQuery)