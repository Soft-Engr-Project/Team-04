<html>
    <head>
        <style type= "text/css">
            body{background-color:"#CCD9f9";
                font-family: Verdana, Geneva, sans-serif
            }
            h3{color:#4C628D}
            p{font-weight:bold}
        </style>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/flatly/bootstrap.min.css" integrity="sha384-qF/QmIAj5ZaYFAeQcrQ6bfVMAh4zZlrGwTPY7T/M+iTTLJqJBJjwwnsE5Y0mV7QK" crossorigin="anonymous">
    </head>

    <body>
        <div class = "container">
            <div class ="row">
                <div class = "col-md-4">
                    <div class = "card" style = "margin-top: 5rem">
                    <h1>
                        <?php echo $header?>
                    </h1>
                    <p> Hello <?php echo $username?></p>
                    <br>
                    <p><?php echo $body?></p>
                    <form action="<?php echo $link?>">
                        <input type = "submit" value='<?php echo $button?>'/>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>

