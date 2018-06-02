<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat IO</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>


<div class="container mt-5 ">
<div class="card">
    <div class="card-body">

<div class="form-group col-md-6">
    <label for="message">Message</label>
    <input
        type="text"
        class="form-control" name="message" id="message" aria-describedby="message here"
        placeholder="enter message and press enter to send">
</div>

<div class="form-group">
    <textarea class="form-control" name="output" id="output" rows="5" placeholder="received messages will appear here">
    </textarea>
</div>
    </div>
</div>
</div>
<script>

    if(window.WebSocket){
        swock();
    }

    function swock() {
        var conn=new WebSocket("ws://localhost:8000");

        conn.onopen=(function (e) {
            console.log("connection established");
        });

        conn.onmessage=(function (e) {
            document.getElementById("output").innerHTML=e.data
        })

        //on type
        var inp=document.getElementById("message");
        inp.addEventListener("keyup",function (e) {
            if(e.keyCode===13){//enter key pressed
                if(inp.value!==''){ //send only if the input is not null
                    conn.send(inp.value);
                    inp.value='';//clear the input
                }
            }
        });
    }

</script>
</body>
</html>