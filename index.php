<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class=" center-align"
        style="display: flex; flex-direction: column; align-items : center; justify-content: center; height: 100vh">

        <div class="row">
            <h3>Otp Bomber</h3>
        </div>
        <div style="border: 1px solid #ccc; padding : 3%" class="row ">
            <form action="index.php">
                <div class="col s12">
                    <div class="input-field">
                        <input name="num" type="tel" id="input-field" class="validate">
                        <label for="input-field">Enter Number</label>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" value="submit" name="submit">Submit</button>
                </div>
                
            </form>
            <div class="">
            <?php 
                
                require "main.php";
                if (isset($_GET['submit'])) {
                    
                    $num = $_GET['num'];
                    
                    run($num);
                }

            
            ?>
            </div>
        </div>
    </div>

    <style>
    h3 {
        font-size: 3rem;
        font-weight: bold;
        color: #26a69a;

        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    </style>


</body>

</html>