<?php
  require 'vendor/autoload.php';
  use benhall14\phpCalendar\Calendar as Calendar;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" type="text/css" href="styles/calendar.css">
    <title>Christmas Pelago</title>
</head>

<body>

    <div class="body-wrapper">

        <header>
            <nav></nav>
            <h1>
                Christmas-Pelago
            </h1>
        </header>

        <section class="hotel-info-section">
            <h2>
                About hotel
            </h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla laborum iste assumenda aspernatur ratione nihil eos explicabo saepe temporibus fugiat molestiae commodi, consequuntur numquam dolores praesentium architecto corrupti rem. Nulla?
                Doloremque inventore dolores pariatur cumque, porro exercitationem! Cumque harum praesentium animi optio veritatis aperiam temporibus soluta? Ullam possimus quasi eum in necessitatibus praesentium, est cupiditate modi voluptatem, vitae reprehenderit ipsa.
                Doloribus obcaecati voluptas necessitatibus modi, molestiae accusantium perferendis sed saepe in est accusamus nobis iusto iure, animi quibusdam assumenda unde blanditiis, nisi eveniet beatae culpa itaque! Deleniti modi officia sed?
            </p>
        </section>

        <section class="picture-section">
            <div class="grid-container">
                <div class="grid-item">
                    <p>
                        Budget
                    </p>
                    <img src="" alt="">
                </div>
                <div class="grid-item">
                    <p>
                        Standard
                    </p>
                    <img src="" alt="">
                </div>
                <div class="grid-item">
                    <p>
                        Luxury
                    </p>
                    <img src="" alt="">
                </div>
            </div>
        </section>

        <section class="calendar-section">
           <?php
              $calendar = new calendar;
              $calendar->stylesheet();

//               (new calendar)->display();
                    echo $calendar->draw(date('Y-01-01'));

           ?>
        </section>

        <section class="option-selection">
           <div class="form-container">
                    <form action="/index.php" method="post">
                           <div class="form-wrapper">
                           <label for="name">Name</label>
                           <input type="text" name="name" placeholder="John Doe">

                           <div class="select-box">
                           <select name="room-options" id="room-options">
                             <option value="Budget">Budget</option>
                             <option value="Standard">Standard</option>
                             <option value="Luxury">luxury</option>
                           </select>
                           <input type="submit">
                           </div>
                           </div>

                           <div class="checkbox-container">
                                 <div>
                                        <input type="checkbox" name="breakfast">
                                        <label for="breakfast">breakfast</label>
                                 </div>

                                 <div>
                                        <input type="checkbox" name="ocean-view">
                                        <label for="ocean-view">ocean-view</label>
                                 </div>

                                 <div>
                                        <input type="checkbox" name="room-service">
                                        <label for="room-service">room-service</label>
                                 </div>
                           </div>

                    </form>
           </div>
        </section>

        <footer></footer>
    </div>
</body>


</html>
