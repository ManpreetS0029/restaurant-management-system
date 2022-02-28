<ul class="sidebar-menu">
            <!-- <li class="menu-header">Main</li> -->

            <?php


              $sql = $conn->prepare("select * from user_table where user_id = '".$_SESSION['user_id']."'");
              $sql->execute();
              $rows = $sql->fetchAll();

              foreach($rows as $row )
              {
                if($row["user_type"] == "Waiter")
                {

            ?>

            <li class="dropdown" id="order">
              <a href="order.php" class="nav-link"><i data-feather="shopping-cart"></i><span>Order</span></a>
            </li>

            <?php

                }
                else
                {

                  ?>

              <li class="dropdown" id="billing">
              <a href="cashier.php" class="nav-link"><i data-feather="dollar-sign"></i><span>Billing</span></a>
              </li>
              </ul>


              <?php
              }
            }

              ?>
