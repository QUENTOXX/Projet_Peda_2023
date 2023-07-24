<?php
  include ("header.php");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Commandes</title>
  <link rel="stylesheet" type="text/css" href="/projet_pedago/css/commandes.css" href="/projet_pedago/css/Main.css">
</head>

<body>
  <h1>Commandes</h1>
  <div class="historic-container">
  <div class="historic">
      <ul class="order-list">
              <li >
                <div class="commandes">
                  <div class="order-details">
                      <h2>Order #12345</h2>
                      <p>Date: January 1, 2023</p>
                      <p>Total: $50.00</p>
                      <p>Status: Shipped</p>
                  </div>
                  <div class="order-items">
                      <h3>Produits Commandés</h3>
                      <ul>
                          <li>Product 1 (Quantity: 2)</li>
                          <li>Product 2 (Quantity: 1)</li>
                      </ul>
                  </div>
                </div> 
              </li>

              <li >
                <div class="commandes">
                <div class="order-details">
                        <h2>Order #67890</h2>
                        <p>Date: January 2, 2023</p>
                        <p>Total: $100.00</p>
                        <p>Status: Shipped</p>
                    </div>
                    <div class="order-items">
                        <h3>Produits Commandés</h3>
                        <ul>
                            <li>Product 1 (Quantity: 2)</li>
                            <li>Product 2 (Quantity: 1)</li>
                            <li>Product 3 (Quantity: 3)</li>
                        </ul>
                    </div>           
                 </div>
              </li>
          </ul>
      </div>
  </div>
</body>

</html>
<?php
  include ("footer.php");
?>