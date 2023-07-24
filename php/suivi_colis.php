<!DOCTYPE html>
<html>
<head>
  <title>Suivi de colis</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/suivi.css" href="/projet_pedago/css/Main.css">
</head>
<?php
  include ("header.php");
?>
<body>
  <h1>Suivi de colis</h1>

  <div class="notification-container">
  
    <div class="notification" id="notification">Placeholder</div>
  
  </div>

  <script type="text/Javascript">

    document.addEventListener('DOMContentLoaded', function () {
        // Function to display notifications
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.innerHTML = message;
            notification.style.display = 'block';


        }

      });

  </script>


</body>

</html>
<?php
  include ("footer.php");
?>