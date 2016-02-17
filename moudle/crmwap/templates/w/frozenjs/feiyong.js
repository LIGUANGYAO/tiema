//传入项目评估总值,项目评估率数组
function getnew(zcpg_val,arr,sl,qianz){
    $('.'+qianz+'sumnl').text('');
   
    $('#'+qianz+'sum').text('');
    
    $('#'+qianz+'sum2').text('');
    $('#'+qianz+'sum3').text('');
    $('#'+qianz+'sum4').text('');
    $('#'+qianz+'sum5').text('');
    $('#'+qianz+'sum6').text('');
    if(zcpg_val>0)
    {
        $('.'+qianz+'sumnl').each(function(){
        $(this).parent().hide();
        });
        //zcpg_val=zcpg_val*10000;
        zcpg_val=zcpg_val;
    }
    else
    {
        $('.'+qianz+'sumnl').each(function(){
        $(this).parent().show();
        });  
        return 0;
    }
    
    
    
    if(zcpg_val>=arr['0']['0'] && zcpg_val<=arr['0']['1'])  //100以下（含100）
    {
        var val=0;var jsl=0;var sum=0;var lilv=arr['0']['2'];
        //100w以下
        val=zcpg_val;jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        sum_count=sum;
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        
    }
    else if(zcpg_val>arr['1']['0'] && zcpg_val<=arr['1']['1'])  //101--1000（含1000）
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        
        //100w-1000w以下
        var val2=0;var jsl2=0;var zcpg_val_r=0;var sum2=0;var lilv2=arr['1']['2'];
        zcpg_val_r=zcpg_val-arr['0']['1'];
        val2=zcpg_val_r;jsl2=lilv2/100;
        sum2=Math.ceil(val2*jsl2);
        
        sum_count=sum+sum2;
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
     
        
    }
    else if(zcpg_val>arr['2']['0'] && zcpg_val<=arr['2']['1']) //1000-2000
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];     
        val2=arr['1']['1']-arr['1']['0'];jsl2=lilv2/100;
        sum2=Math.ceil(val2*jsl2);
        

        //1000-2000
        var val3=0;var jsl3=0;var zcpg_val_r=0;var sum3=0;var lilv3=arr['2']['2'];
        zcpg_val_r=zcpg_val-arr['1']['1'];
        val3=zcpg_val_r;jsl3=lilv3/100;
        sum3=Math.ceil(val3*jsl3);
        
        sum_count=sum+sum2+sum3;
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        
    }
    else if(zcpg_val>arr['3']['0'] && zcpg_val<=arr['3']['1']) //2000-5000
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];     
        val2=arr['1']['1']-arr['1']['0'];jsl2=lilv2/100;
        sum2=Math.ceil(val2*jsl2);
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        sum3=Math.ceil(val3*jsl3);

        
        //2000-5000
        var val4=0;var jsl4=0;var zcpg_val_r=0;var sum4=0;var lilv4=arr['3']['2']; 
        zcpg_val_r=zcpg_val-arr['2']['1'];
        val4=zcpg_val_r;jsl4=lilv4/100;
        sum4=Math.ceil(val4*jsl4);
        
        sum_count=sum+sum2+sum3+sum4;
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        
    }
    else if(zcpg_val>arr['4']['0'] && zcpg_val<=arr['4']['1'])  //5000-8000
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];     
        val2=arr['1']['1']-arr['1']['0'];jsl2=lilv2/100;
        sum2=Math.ceil(val2*jsl2);
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        sum3=Math.ceil(val3*jsl3);
        
        //2000-5000
        var val4=0;var jsl4=0;var sum4=0;var lilv4=arr['3']['2'];
        val4=arr['3']['1']-arr['3']['0'];jsl4=lilv4/100;
        sum4=Math.ceil(val4*jsl4);
        
        
         //5000-8000
        var val5=0;var jsl5=0;var zcpg_val_r=0;var sum5=0;var lilv5=arr['4']['2'];
        zcpg_val_r=zcpg_val-arr['3']['1'];
        val5=zcpg_val_r;jsl5=lilv5/100;
        sum5=Math.ceil(val5*jsl5);
        
        
        sum_count=sum+sum2+sum3+sum4+sum5;
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        $('#'+qianz+'sum5').text(sum5);
        $('#'+qianz+'sum5').parent().show();
        
    }
     else if(zcpg_val>arr['5']['0']&& zcpg_val<=arr['5']['1'])     //8000-1w
    {
         //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];     
        val2=arr['1']['1']-arr['1']['0'];jsl2=lilv2/100;
        sum2=Math.ceil(val2*jsl2);
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        sum3=Math.ceil(val3*jsl3);
        
        //2000-5000
        var val4=0;var jsl4=0;var sum4=0;var lilv4=arr['3']['2'];
        val4=arr['3']['1']-arr['3']['0'];jsl4=lilv4/100;
        sum4=Math.ceil(val4*jsl4);
        
        
        //5000-8000
        var val5=0;var jsl5=0;var sum5=0;var lilv5=arr['4']['2'];
        val5=arr['4']['1']-arr['4']['0'];jsl5=lilv5/100;
        sum5=Math.ceil(val5*jsl5);
         
        //8000-1w
        var val6=0;var jsl6=0;var zcpg_val_r=0;var sum6=0;var lilv6=arr['5']['2'];
        zcpg_val_r=zcpg_val-arr['4']['1'];
        val6=zcpg_val_r;jsl6=lilv6/100;
        sum6=Math.ceil(val6*jsl6);
        
        
        sum_count=sum+sum2+sum3+sum4+sum5+sum6;
         
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        $('#'+qianz+'sum5').text(sum5);
        $('#'+qianz+'sum5').parent().show();
        $('#'+qianz+'sum6').text(sum6);
        $('#'+qianz+'sum6').parent().show();
    }
    else if(zcpg_val>=arr['6']['0'])     //8000-1w
    {
         //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        sum=Math.ceil(val*jsl);
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];     
        val2=arr['1']['1']-arr['1']['0'];jsl2=lilv2/100;
        sum2=Math.ceil(val2*jsl2);
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        sum3=Math.ceil(val3*jsl3);
        
        //2000-5000
        var val4=0;var jsl4=0;var sum4=0;var lilv4=arr['3']['2'];
        val4=arr['3']['1']-arr['3']['0'];jsl4=lilv4/100;
        sum4=Math.ceil(val4*jsl4);
        
        
        //5000-8000
        var val5=0;var jsl5=0;var sum5=0;var lilv5=arr['4']['2'];
        val5=arr['4']['1']-arr['4']['0'];jsl5=lilv5/100;
        sum5=Math.ceil(val5*jsl5);
        
        //8000-1w
        var val6=0;var jsl6=0;var zcpg_val_r=0;var sum6=0;var lilv6=arr['5']['2'];
        val6=arr['5']['1']-arr['5']['0'];jsl6=lilv6/100;
        sum6=Math.ceil(val6*jsl6);
        
         //1w+
        var val7=0;var jsl7=0;var zcpg_val_r=0;var sum7=0;var lilv7=arr['6']['2'];
        zcpg_val_r=zcpg_val-arr['5']['1'];
        val7=zcpg_val_r;jsl7=lilv7/100;
        sum7=Math.ceil(val7*jsl7);
        
        sum_count=sum+sum2+sum3+sum4+sum5+sum6+sum7;
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        $('#'+qianz+'sum5').text(sum5);
        $('#'+qianz+'sum5').parent().show();
        $('#'+qianz+'sum6').text(sum6);
        $('#'+qianz+'sum6').parent().show();
        $('#'+qianz+'sum7').text(sum7);
        $('#'+qianz+'sum7').parent().show();
       
      
    }
    
    return sum_count;
    //alert(sum_count);
       
}



//传入项目评估总值,项目评估率数组
function getnew_gd(zcpg_val,arr,sl,qianz){
    $('.'+qianz+'sumnl').text('');
   
    $('#'+qianz+'sum').text('');
    
    $('#'+qianz+'sum2').text('');
    $('#'+qianz+'sum3').text('');
    $('#'+qianz+'sum4').text('');
    $('#'+qianz+'sum5').text('');
    $('#'+qianz+'sum6').text('');
    if(zcpg_val>0)
    {
        $('.'+qianz+'sumnl').each(function(){
        $(this).parent().hide();
        });
        //zcpg_val=zcpg_val*10000;
        zcpg_val=zcpg_val;
    }
    else
    {
        $('.'+qianz+'sumnl').each(function(){
        $(this).parent().show();
        });  
        return 0;
    }
    
    
    
    if(zcpg_val>=arr['0']['0'] && zcpg_val<=arr['0']['1'])  //100以下（含100）
    {
        var val=0;var jsl=0;var sum=0;var lilv=arr['0']['2'];
        //100w以下
        
        val=zcpg_val;jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
    
        sum_count=sum+arr['0']['4'];
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        
    }
    else if(zcpg_val>arr['1']['0'] && zcpg_val<=arr['1']['1'])  //101--1000（含1000）
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
       
        
        //100w-1000w以下
        var val2=0;var jsl2=0;var zcpg_val_r=0;var sum2=0;var lilv2=arr['1']['2'];
        if(arr['0']['3']==2)
        {
            sum=0;
            zcpg_val_r=zcpg_val;
        }else
        {
            zcpg_val_r=zcpg_val-arr['0']['1'];
        }
        
        val2=zcpg_val_r;jsl2=lilv2/100;
        if(arr['1']['3']==2)
        {
            sum2=arr['1']['2'];;
        }else
        {
            sum2=Math.ceil(val2*jsl2);
        }
        //sum2=Math.ceil(val2*jsl2);
        
        sum_count=sum+sum2+arr['0']['4']+arr['1']['4'];
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
     
        
    }
    else if(zcpg_val>arr['2']['0'] && zcpg_val<=arr['2']['1']) //1000-2000
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
        
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];  
        if(arr['0']['3']==2)
        {
            sum=0;
            
            val2=arr['1']['1'];
        }else
        {
            val2=arr['1']['1']-arr['1']['0'];
        }   
        jsl2=lilv2/100;
        if(arr['1']['3']==2)
        {
            sum2=arr['1']['2'];;
        }else
        {
            sum2=Math.ceil(val2*jsl2);
        }
        

        //1000-2000
        var val3=0;var jsl3=0;var zcpg_val_r=0;var sum3=0;var lilv3=arr['2']['2'];
        if(arr['1']['3']==2)
        {
            sum=0;
            sum2=0;
            zcpg_val_r=zcpg_val;
        }else
        {
            zcpg_val_r=zcpg_val-arr['1']['1'];
        }
        
        val3=zcpg_val_r;jsl3=lilv3/100;
        if(arr['2']['3']==2)
        {
            sum3=arr['2']['2'];;
        }else
        {
            sum3=Math.ceil(val3*jsl3);
        }
         
        sum_count=sum+sum2+sum3+arr['0']['4']+arr['1']['4']+arr['2']['4'];
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        
    }
    else if(zcpg_val>arr['3']['0'] && zcpg_val<=arr['3']['1']) //2000-5000
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
        
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];  
        if(arr['0']['3']==2)
        {
            sum=0;
            
            val2=arr['1']['1'];
        }else
        {
            val2=arr['1']['1']-arr['1']['0'];
        }   
        jsl2=lilv2/100;
        if(arr['1']['3']==2)
        {
            sum2=arr['1']['2'];;
        }else
        {
            sum2=Math.ceil(val2*jsl2);
        }
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        if(arr['1']['3']==2)
        {
            sum=0;
            sum2=0;
            val3=arr['2']['1'];jsl3=lilv3/100;
        }else
        {
            val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        }
        
        
        if(arr['2']['3']==2)
        {
            sum3=arr['2']['2'];;
        }else
        {
            sum3=Math.ceil(val3*jsl3);
        }

        
        //2000-5000
        var val4=0;var jsl4=0;var zcpg_val_r=0;var sum4=0;var lilv4=arr['3']['2']; 
        if(arr['2']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            
            zcpg_val_r=zcpg_val;
        }else
        {
           zcpg_val_r=zcpg_val-arr['2']['1'];
        }
        
        val4=zcpg_val_r;jsl4=lilv4/100;
        if(arr['3']['3']==2)
        {
            sum4=arr['3']['2'];;
        }else
        {
            sum4=Math.ceil(val4*jsl4);
        }
        
        sum_count=sum+sum2+sum3+sum4+arr['0']['4']+arr['1']['4']+arr['2']['4']+arr['3']['4'];
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        
    }
    else if(zcpg_val>arr['4']['0'] && zcpg_val<=arr['4']['1'])  //5000-8000
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
        
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];  
        if(arr['0']['3']==2)
        {
            sum=0;
            
            val2=arr['1']['1'];
        }else
        {
            val2=arr['1']['1']-arr['1']['0'];
        }   
        jsl2=lilv2/100;
        if(arr['1']['3']==2)
        {
            sum2=arr['1']['2'];;
        }else
        {
            sum2=Math.ceil(val2*jsl2);
        }
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        if(arr['1']['3']==2)
        {
            sum=0;
            sum2=0;
            val3=arr['2']['1'];jsl3=lilv3/100;
        }else
        {
            val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        }
        
        
        if(arr['2']['3']==2)
        {
            sum3=arr['2']['2'];;
        }else
        {
            sum3=Math.ceil(val3*jsl3);
        }
        
        //2000-5000
        var val4=0;var jsl4=0;var sum4=0;var lilv4=arr['3']['2'];
        if(arr['2']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            val4=arr['3']['1'];jsl4=lilv4/100;
        }else
        {
            val4=arr['3']['1']-arr['3']['0'];jsl4=lilv4/100;
        }
        
        if(arr['3']['3']==2)
        {
            sum4=arr['3']['2'];;
        }else
        {
            sum4=Math.ceil(val4*jsl4);
        }
        
        
         //5000-8000
        var val5=0;var jsl5=0;var zcpg_val_r=0;var sum5=0;var lilv5=arr['4']['2'];
        if(arr['3']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            sum4=0;
            zcpg_val_r=zcpg_val;
        }else
        {
            zcpg_val_r=zcpg_val-arr['3']['1'];
        }
        
        val5=zcpg_val_r;jsl5=lilv5/100;
        if(arr['4']['3']==2)
        {
            sum5=arr['4']['2'];;
        }else
        {
            sum5=Math.ceil(val5*jsl5);
        }
        
        
        sum_count=sum+sum2+sum3+sum4+sum5+arr['0']['4']+arr['1']['4']+arr['2']['4']+arr['3']['4']+arr['4']['4'];
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        $('#'+qianz+'sum5').text(sum5);
        $('#'+qianz+'sum5').parent().show();
        
    }
     else if(zcpg_val>arr['5']['0']&& zcpg_val<=arr['5']['1'])     //8000-1w
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
        
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];  
        if(arr['0']['3']==2)
        {
            sum=0;
            
            val2=arr['1']['1'];
        }else
        {
            val2=arr['1']['1']-arr['1']['0'];
        }   
        jsl2=lilv2/100;
        if(arr['1']['3']==2)
        {
            sum2=arr['1']['2'];;
        }else
        {
            sum2=Math.ceil(val2*jsl2);
        }
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        if(arr['1']['3']==2)
        {
            sum=0;
            sum2=0;
            val3=arr['2']['1'];jsl3=lilv3/100;
        }else
        {
            val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        }
        
        
        if(arr['2']['3']==2)
        {
            sum3=arr['2']['2'];;
        }else
        {
            sum3=Math.ceil(val3*jsl3);
        }
        
        //2000-5000
        var val4=0;var jsl4=0;var sum4=0;var lilv4=arr['3']['2'];
        if(arr['2']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            val4=arr['3']['1'];jsl4=lilv4/100;
        }else
        {
            val4=arr['3']['1']-arr['3']['0'];jsl4=lilv4/100;
        }
        
        if(arr['3']['3']==2)
        {
            sum4=arr['3']['2'];;
        }else
        {
            sum4=Math.ceil(val4*jsl4);
        }
        
        //5000-8000
        var val5=0;var jsl5=0;var sum5=0;var lilv5=arr['4']['2'];
        if(arr['3']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            sum4=0;
            
             val5=arr['4']['1']-arr['4']['0'];jsl5=lilv5/100;
        }else
        {
            val5=arr['4']['1']-arr['4']['0'];jsl5=lilv5/100;
        }
        
        if(arr['4']['3']==2)
        {
            sum5=arr['4']['2'];;
        }else
        {
            sum5=Math.ceil(val5*jsl5);
        }
         
        //8000-1w
        var val6=0;var jsl6=0;var zcpg_val_r=0;var sum6=0;var lilv6=arr['5']['2'];
        if(arr['4']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            sum4=0;
            sum5=0;
            zcpg_val_r=zcpg_val;
        }else
        {
           zcpg_val_r=zcpg_val-arr['4']['1'];
        }
        
        val6=zcpg_val_r;jsl6=lilv6/100;
        if(arr['5']['3']==2)
        {
            sum6=arr['5']['2'];;
        }else
        {
            sum6=Math.ceil(val6*jsl6);
        }
        
        
        sum_count=sum+sum2+sum3+sum4+sum5+sum6+arr['0']['4']+arr['1']['4']+arr['2']['4']+arr['3']['4']+arr['4']['4']+arr['5']['4'];
         
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        $('#'+qianz+'sum5').text(sum5);
        $('#'+qianz+'sum5').parent().show();
        $('#'+qianz+'sum6').text(sum6);
        $('#'+qianz+'sum6').parent().show();
    }
    else if(zcpg_val>=arr['6']['0'])     //8000-1w
    {
        //100w以下
        var val=0;var jsl=0;var sum=0;  var lilv=arr['0']['2'];     
        val=arr['0']['1']-arr['0']['0'];jsl=lilv/100;
        if(arr['0']['3']==2)
        {
            sum=arr['0']['2'];
        }else
        {
            sum=Math.ceil(val*jsl);
        }
        
        
         //100w-1000w以下
        var val2=0;var jsl2=0;var sum2=0;var lilv2=arr['1']['2'];  
        if(arr['0']['3']==2)
        {
            sum=0;
            
            val2=arr['1']['1'];
        }else
        {
            val2=arr['1']['1']-arr['1']['0'];
        }   
        jsl2=lilv2/100;
        if(arr['1']['3']==2)
        {
            sum2=arr['1']['2'];;
        }else
        {
            sum2=Math.ceil(val2*jsl2);
        }
        
        
        //1000-2000
        var val3=0;var jsl3=0;var sum3=0;var lilv3=arr['2']['2']; 
        if(arr['1']['3']==2)
        {
            sum=0;
            sum2=0;
            val3=arr['2']['1'];jsl3=lilv3/100;
        }else
        {
            val3=arr['2']['1']-arr['2']['0'];jsl3=lilv3/100;
        }
        
        
        if(arr['2']['3']==2)
        {
            sum3=arr['2']['2'];;
        }else
        {
            sum3=Math.ceil(val3*jsl3);
        }
        
        //2000-5000
        var val4=0;var jsl4=0;var sum4=0;var lilv4=arr['3']['2'];
        if(arr['2']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            val4=arr['3']['1'];jsl4=lilv4/100;
        }else
        {
            val4=arr['3']['1']-arr['3']['0'];jsl4=lilv4/100;
        }
        
        if(arr['3']['3']==2)
        {
            sum4=arr['3']['2'];;
        }else
        {
            sum4=Math.ceil(val4*jsl4);
        }
        
        //5000-8000
        var val5=0;var jsl5=0;var sum5=0;var lilv5=arr['4']['2'];
        if(arr['3']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            sum4=0;
            
             val5=arr['4']['1']-arr['4']['0'];jsl5=lilv5/100;
        }else
        {
            val5=arr['4']['1']-arr['4']['0'];jsl5=lilv5/100;
        }
        
        if(arr['4']['3']==2)
        {
            sum5=arr['4']['2'];;
        }else
        {
            sum5=Math.ceil(val5*jsl5);
        }
         
        
        //8000-1w
        var val6=0;var jsl6=0;var zcpg_val_r=0;var sum6=0;var lilv6=arr['5']['2'];
        if(arr['4']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            sum4=0;
            sum5=0;
            val6=arr['5']['1'];jsl6=lilv6/100;
        }else
        {
            val6=arr['5']['1']-arr['5']['0'];jsl6=lilv6/100;
        }
        
        if(arr['5']['3']==2)
        {
            sum6=arr['5']['2'];;
        }else
        {
            sum6=Math.ceil(val6*jsl6);
        }
        
         //1w+
        var val7=0;var jsl7=0;var zcpg_val_r=0;var sum7=0;var lilv7=arr['6']['2'];
        if(arr['5']['3']==2)
        {
            sum=0;
            sum2=0;
            sum3=0;
            sum4=0;
            sum5=0;
            sum6=0;
            zcpg_val_r=zcpg_val;
        }else
        {
            zcpg_val_r=zcpg_val-arr['5']['1'];
        }
        
        val7=zcpg_val_r;jsl7=lilv7/100;
        if(arr['5']['3']==2)
        {
            sum7=arr['5']['2'];;
        }else
        {
            sum7=Math.ceil(val7*jsl7);
        }
        
        sum_count=sum+sum2+sum3+sum4+sum5+sum6+sum7+arr['0']['4']+arr['1']['4']+arr['2']['4']+arr['3']['4']+arr['4']['4']+arr['5']['4']+arr['6']['4'];
        
        $('#'+qianz+'sum').text(sum);
        $('#'+qianz+'sum').parent().show();
        $('#'+qianz+'sum2').text(sum2);
        $('#'+qianz+'sum2').parent().show();
        $('#'+qianz+'sum3').text(sum3);
        $('#'+qianz+'sum3').parent().show();
        $('#'+qianz+'sum4').text(sum4);
        $('#'+qianz+'sum4').parent().show();
        $('#'+qianz+'sum5').text(sum5);
        $('#'+qianz+'sum5').parent().show();
        $('#'+qianz+'sum6').text(sum6);
        $('#'+qianz+'sum6').parent().show();
        $('#'+qianz+'sum7').text(sum7);
        $('#'+qianz+'sum7').parent().show();
       
      
    }
    
    return sum_count;
    //alert(sum_count);
       
}