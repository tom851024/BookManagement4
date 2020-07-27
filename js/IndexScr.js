function con(id){ //刪除資料確認提示
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var order = url.searchParams.get('order');
    var page = url.searchParams.get('page');
    if (confirm("確定要刪除？")) {
        if(order == null && page == null){
            location.href='Delete.php?id='+id;
         }else if(order == null){
            location.href='Delete.php?id='+id+'&page='+page;
         }else if(page == null){
            location.href='Delete.php?id='+id+'&order='+order;
         }else{
             location.href='Delete.php?id='+id+'&order='+order+'&page='+page;
         }
        
    }
}


window.onload=function(){ //select排序設定
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var order = url.searchParams.get('order');
    var obj = document.getElementById("order");
    var opts=obj.getElementsByTagName("option");

    var select = document.getElementById("orders");

    for(var i = 0; i < select.length; i++){
        if(order == select[i].value){
            opts[i].selected = true;
        }
    }
    
    
}




function output_post(){ //匯出post送出
    var data = $("input[name='data[]']:checked").map(function(){return $(this).val();}).get();
    document.getElementById("dataSub").value = data;
    document.output.submit();
}



    
function order_change(){ //select變動時排序
    var order = document.getElementById("orders").value;
    var getUrlString = location.href; //取得get參數
    var url = new URL(getUrlString);
    var page = url.searchParams.get('page');
    if(page == null){
        location.href = 'index.php?order='+order;
    }else{
        location.href = 'index.php?page='+page+'&order='+order;
    }
}


document.write("<div id='tip' style='position:absolute; z-index:1; background-color: #F1F1F1; border: 2px solid #000; overflow: visible;visibility: hidden;font-size:12px;padding:13px;color:#333333'></div>");
function showtip(w, obj, num){ //顯示小視窗
    var x = obj.offsetLeft;
    if(num == 0){
        x+=1150;
        tip.style.width = "45px";
        tip.style.visibility = "visible";
    }else if(num == 1 && w != ""){
        x+= 100;
        tip.style.width = "250px";
        tip.style.visibility = "visible";
    }
    var y = obj.offsetTop;
    y += 70;
    tip.innerHTML = w;
    tip.style.left = x+"px";
    tip.style.top = y+"px";
}
function hidetip(){ //隱藏小視窗
tip.style.innerHTML = ""
tip.style.visibility = "hidden";
}


function page_post(pages){ //輸入頁碼判斷
    
    var pageBoo = 1;
    var re = /^[0-9]+$/;//判斷字串是否為數字//判斷正整數/[1−9] [0−9]∗]∗/ 
    var page = document.getElementById("pageInp").value;

    if (!re.test(page)) { 
        pageBoo = 0;
    } 

    if (page != null) {
        if (page > pages) {
            alert('超出最大頁數');
            return;
        }else if(page === "0" || page < 0) {
            alert('超出最小頁數');
            return;
        }
                
    }
            
    if(pageBoo == 0){
        alert('頁碼格式錯誤');
        return;
    }
    
    document.pForm.submit();
    
    
    
}

function page_move(pages, url, page){ //換頁判斷
    var pageBoo = 1;
    var re = /^[0-9]+$/;//判斷字串是否為數字//判斷正整數/[1−9] [0−9]∗]∗/ 
    if (!re.test(page)) { 
        pageBoo = 0;
    }
    if (page != null) {
        if (page > pages) {
            alert('超出最大頁數');
            return;
        }else if(page === 0 || page === "0" || page < 0) {
            alert('超出最小頁數');
            return;
        }
                
    }
            
    if(pageBoo == 0){
        alert('頁碼格式錯誤');
        return;
    }

    location.href = url;
}


