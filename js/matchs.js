var getUrlString = location.href; //取得get參數
var url = new URL(getUrlString);
var isbn = url.searchParams.get('isbn');
var price = url.searchParams.get('price');
var date = url.searchParams.get('date');
var sign = url.searchParams.get('sign');
var id = url.searchParams.get('id');

if(isbn == '1'){
    alert('ISBN格式輸入錯誤');
    if(id == null){
        history.go(-1);
    }
}else if(price == '1'){
    alert('價格格式輸入錯誤');
    if(id == null){
        history.go(-1);
    }
}else if(date == '1'){
    alert('發行日格式輸入錯誤');
    if(id == null){
        history.go(-1);
    }
}else if(sign == '1'){
    alert('不可輸入逗號');
    if(id == null){
        history.go(-1);
    }
}

