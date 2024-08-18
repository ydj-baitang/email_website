window.onload=function(){
    var a = document .getElementsByTagName('a');
    a[0] .onclick = function() {
        this .className =""; //设置为空，不应用任何样式
        document . getElementById('cont1') .style .display = 'block';
        a[1].className ="tab2";
        document . getElementById('cont2') .style . display = 'none';
    }
    a[1] .onclick = function() {
        this.className ="";
        document . getElementById('cont2').style .display =  'block';
        a[0].className = "tab1";
        document .getElementById('cont1') .style . display = 'none';
    }
}