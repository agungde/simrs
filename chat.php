  <style>
  body
  {
   margin:0;
   padding:0;
  }
  .box
  {
   width:500px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  #load_tweets
  {
   padding:16px;
   background-color:#f1f1f1;
   margin-bottom:30px;
  }
  #load_tweets p
  {
   padding:12px;
   border-bottom:1px dotted #ccc;
  }
  </style>
<link rel="stylesheet" href="css.css" />
<button class="open-button"onclick="openForm()">Chat</button>
<div class="chat-popup" id="myForm">
  <form action="/action_page.php" class="form-container">
   <i class="fa-solid fa-chalkboard-user"></i> <h3>Chat with us</h3>
<div id="load_tweets"></div>
<input type="text" name="msg" class="btn">
    <button type="submit" class="btn">Send</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
  </form>
</div>
<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>