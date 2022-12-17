function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function get_ajax_response_text(jqXHR) {
    return jqXHR.responseText;
}

function print_circle_image(canvasName, imageSrc, x_move, y_move, scale, background_color) {
    var myImage = new Image();

    scale /= 10;
    canvas = document.getElementById(canvasName);
    canvas.width = canvas.width;     // Clear canvas
    var size = canvas.height;
    if (!canvas.getContext) return;
    ctx = canvas.getContext("2d");
    myImage.src = imageSrc;
    return new Promise((resolve) => {
        myImage.onload = function() {
            if(myImage.width >= myImage.height) {
                if(x_move == null)
                    x_move = canvas.height * ((myImage.height - myImage.width) / 2) / myImage.height * (scale * 1.02)
                ctx.drawImage(myImage, x_move, y_move, (myImage.width / (myImage.height / size))* scale , size* scale );
            } else {
                if(y_move == null)
                    y_move = canvas.width * ((myImage.width - myImage.height) / 2) / myImage.width  * (scale * 1.02)
                ctx.drawImage(myImage, x_move, y_move, size * scale, (myImage.height / (myImage.width / size)) * scale);
            }
            ctx.strokeStyle = background_color
            ctx.lineWidth = (size/2).toString();
            ctx.beginPath();
            ctx.arc(size/2, size/2, size*0.75, 0, Math.PI * 2, true);
            ctx.closePath();
            ctx.stroke();
            resolve([x_move, y_move, scale*10])
        }
    })
}