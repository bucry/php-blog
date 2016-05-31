<script type="text/javascript">
    (function() {
        var gid = function(id) {
            return document.getElementById(id);
        }
        var msg= gid("kgweiyu_msg").value;
        var kgw = gid("kgweiyu");
        var baseUrl = gid("kgweiyu_baseUrl").value + "wyreply/";
        var tx = gid("kgweiyu_t");
        tx.onclick = function() {
            window.open(baseUrl + tx.msgId);
        };
        if (msg) {
            msg = eval("(" + msg + ")");
        }
        var len = msg.length;
        if (len <= 0) {
            return;
        }
        var index = 0;
        var h = parseInt(tx.offsetHeight);
        var startT = parseInt(tx.style.top);
        tx.index = index;
        //console.log("height is " + h);
        function ScrollUp() {
            //alert(msg[index] + tx.top);
            tx.innerHTML = msg[index] && msg[index].msg;
            tx.msgId = msg[index] && msg[index].id;
            var top = parseInt(tx.style.top);
            //console.log("top is " + top);
            if (top <= startT - h) {
                tx.style.top = h + "px";
                index ++;
                if (index >= len) {
                    index = 0;
                }
                tx.index = index;
            } else {
                tx.style.top = (top - 1) + "px";
            }
            if (top == startT) {
                setTimeout(ScrollUp, 3000);
            } else {
                setTimeout(ScrollUp, 10);
            }
        }
        ScrollUp();
    })();
</script>