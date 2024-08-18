function validate(){
    var psd1Val = document.getElementById('psd1').value;
    var psd2 = document.getElementById('psd2');
    var psd2Val = psd2.value;
    if (psd2Val != psd1Val ){
        alert("两次输入的密码必须一致");
        psd2.focus();
        return false;
    }
}
function yzmupdate(){
    document.yzm.src="yzm.php?" + Math.random();
}
function createXML() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
}

function check() {
    var emailTxt = document.getElementById('emailaddr');
    var emailAddr = emailTxt.value;
    var url = "../check.php";
    var postStr = "emailaddr=" + encodeURIComponent(emailAddr);
    var xml = createXML();

    // 调试信息
    console.log("Checking email:", emailAddr);

    xml.open("POST", url, true);
    xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf8");
    xml.send(postStr);
    xml.onreadystatechange = function() {
        if (xml.readyState == 4) {
            if (xml.status == 200) {
                var res = JSON.parse(xml.responseText);
                console.log("Response:", res);
                if (res.exists) {
                    alert(res.message);
                    emailTxt.focus();
                    emailTxt.value = '';
                }
            } else {
                console.error("Request failed with status:", xml.status);
            }
        }
    }
}