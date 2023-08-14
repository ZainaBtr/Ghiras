<!DOCTYPE html>
<html>
<head>
    <title>Add Food Category</title>
</head>
<body>
<h1>Add Food Category</h1>
<form action="/categories" method="POST">
    @csrf
    <label for="category_name">Name:</label><br>
    <input type="text" id="category_name" category_name="category_name"><br><br>

    <input type="submit" value="Submit">
</form>
</body>
</html>
