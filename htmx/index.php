<!DOCTYPE html>
<html lang="en">
<head>
    <title>HTMX Practice</title>
</head>
<body>

    <h1>My First HTMX App</h1>

    <!-- <button
        hx-get="message.php"
        hx-target="#result" 
        hx-swap="innerHTML">
        Click Me
    </button>

    <div id="result">
        The message will appear here.
    </div> -->

    <form hx-post="greet.php"
        hx-target="#result"
        hx-swap="innerHTML">

        <input type="text"
            name="username"
            placeholder="Enter your name">

        <button type="submit">Say Hello</button>

    </form>

    <div id="result"></div>



</body>
    <script src="htmx.min.js"></script>
</html>