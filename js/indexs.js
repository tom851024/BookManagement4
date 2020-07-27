$(document).ready(function(){
    $("#CheckAll").click(function(){
        if($("#CheckAll").prop("checked")){ //如果全選按鈕有被選擇
            $("input[name='data[]']").each(function(){
                $(this).prop("checked", true); //把所有選取方塊選取
            })
        }else{
            $("input[name='data[]']").each(function(){
                $(this).prop("checked", false); //把所有方塊都取消
            })
        }
    })
})

