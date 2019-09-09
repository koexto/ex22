BX.ready(function(){
    BX.bind(BX('linkComplaint'), 'click', function(e) {
        var products = BX('complaint');
        BX.PreventDefault(e);
        BX.ajax.loadJSON(
            "?plaint=y",
            function(data){
                products.append("Ваше мнение учтено, №" + data.id);
                //let responce = document.getElementById('complaint');
                //responce.innerText = "Ваше мнение учтено, № " + data.id`;
            },
            function(data){
                products.append("Не удалось сохранить жалобу (:");
            }
    );
    })
});