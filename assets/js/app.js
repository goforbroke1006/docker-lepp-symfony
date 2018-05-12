// alert('wildfowl!');

function selectOptionHandler(f) {
    return function () {
        f.value = this.innerHTML;
        list.innerHTML = '';
    }
}

var input = document.getElementById("queryBox");
var list = document.getElementById("options");
input.oninput = function () {
    if (input.value.length >= 3) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                list.innerHTML = '';
                var objects = JSON.parse(this.responseText);
                for (var i = 0; i < 6; i++) {
                    if (undefined === objects[i]) {
                        break;
                    }
                    var li = document.createElement('li');
                    li.onclick = selectOptionHandler(input);
                    li.innerHTML = objects[i]["content"];
                    list.appendChild(li);
                }
            }
        };
        xhr.open(
            "GET",
            "/api/address/" + input.value,
            true
        );
        xhr.send();
    }
};