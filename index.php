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
        </style>
    </head>
    <body>
        <form action="" method="post">
            <input type="text" name="comune" id="comune" placeholder="Comune" />
            <input type="text" name="cap" id="cap" placeholder="CAP" />
            <input type="submit" value="Aggiungi" onclick="addComune();" />
            <input type="submit" value="elimina" onclick="deleteComune();" />
        </form>

        <form action="" method="post">
            <input type="text" name="comune" id="modComune" placeholder="Nuovo nome" />
            
            <input type="submit" value="Modifica" onclick="updateComune();" />
        </form>

        <div class=".cont-data">
            <ul id="cont-data"></ul>
        </div>
        
        <script>
            getComuni();
        </script>
    </body>
</html>