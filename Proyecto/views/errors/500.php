<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Final UTN"</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: "Gill Sans Extrabold", Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background-color: #565a5d;
        }

        .error-title {
            margin-bottom: 2px;
            color: #222831;
        }

        .error-section {
            text-align: center;
            padding: 50px;
        }

        .error-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #eeeeee;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .go-back {
            padding: 10px 20px;
            margin: 5px auto;
            font-size: 16px;
            font-weight: 500;
            border: none;
            border-radius: 5px;
            background-color: #00adb5;
            color: #eeeeee;
            cursor: pointer;
            text-decoration: none;

        }

        .go-back:hover {
            background-color: #76ebf1;
        }
    </style>
</head>

<body>
    <main>
        <section class="error-section">
            <div class="error-content">
                <h2 class="error-title">Error 500</h2>
                <p>¡Lo sentimos, ocurrio un error!</p>
            </div>
            <button class="go-back" onclick="goBack()">Volver</button>

            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </section>
    </main>
</body>

</html>