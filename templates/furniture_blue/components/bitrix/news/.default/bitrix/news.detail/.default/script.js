//попробовать прямо здесь условие по параметру php if()
BX.ready(function(){
    console.log('sdfsdfsdf');
    BX.bind(BX('complaint'), 'click', function(e) {
        alert('click!');
        BX.PreventDefault(e);
    })
});