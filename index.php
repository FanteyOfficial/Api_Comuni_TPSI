<!DOCTYPE html5>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Codici Postali | HOME</title>
        <script src="script.js"></script>

        <style>
            /* Style for the container */
            .cont-data {
                margin: 20px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            /* Style for the list */
            #cont-data {
                list-style-type: none;
                padding: 0;
            }

            /* Style for list items */
            #cont-data li {
                margin-bottom: 5px;
                padding: 5px 10px;
                background-color: #f0f0f0;
                border-radius: 3px;
            }

            /* Style for the form */
            form {
                display: flex;
                flex-direction: column;
                align-items: start;
                gap: 10px;
            }

            /* Style for the input fields */
            input[type="text"] {
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 3px;
                width: 200px;
            }

            /* Style for the submit buttons */
            input[type="submit"] {
                padding: 5px 10px;
                border: none;
                border-radius: 3px;
                background-color: #007BFF;
                color: white;
                cursor: pointer;
            }

            /* Change the background color of the submit buttons on hover */
            input[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <form action="" method="post">
            <input type="text" name="comune" id="comune" placeholder="Comune" />
            <input type="text" name="cap" id="cap" placeholder="CAP" />
            <input type="submit" value="Aggiungi" onclick="addComune();" />
            <input type="submit" value="elimina" onclick="deleteComune();" />
        </form>

        <hr>

        <form action="" method="post">
            <input type="text" name="comune" id="modComune" placeholder="Nuovo nome" />
            
            <input type="submit" value="Modifica" onclick="updateComune();" />
        </form>

        <hr>

        <div class=".cont-data">
            <ul id="cont-data"></ul>
        </div>
        
        <script>
            getComuni();
        </script>
    </body>
</html>