<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GMBOT | GMBOT</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
  <header>
    <img src="img/playstation-logo.png" alt="PlayStation" class="logo">
    <nav>
      <a href="home.php">HOME</a>
      <a href="about.php">ABOUT</a>
      <a href="gmbot.php" class="active">Q&A</a>
    </nav>
  </header>

  <div class="layout">
    <div class="side">
      <img src="img/sonic.png" alt="Sonic">
    </div>
    <div class="center">
     
      <div class="wrapper">
        <div class="title">GMBOT</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                     <p>Halo, bagaimana GMBOT dapat membantumu?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data" style = "text-align: justify;">
                <input id="data" type="text" placeholder="Ketik disini..." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value = $("#data").val();
                $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
                $(".form").append($msg);
                $("#data").val('');
                
                // start ajax code
                $.ajax({
                    url: 'similarity.php',
                    type: 'POST',
                    data: 'text='+$value,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>
  
<!---->

  </div>
  <div class="side" style="background-color: red;">
      <img src="img/shadow.png" alt="Shadow">
  </div>
</body>

</html>
