<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<h2>Search Tenants</h2>

<div class="input-group" style="width: 40%;">
    <input type="text" class="form-control" id="searchTerm" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon2">
    <button class="btn btn-outline-primary" type="button" onclick="searchTenants()">Search</button>
</div>

<div id="searchResults"></div>

<script>
function searchTenants() {
    var searchTerm = document.getElementById("searchTerm").value;

    $.ajax({
        url: "search.php", // PHP script to handle search
        method: "POST",
        data: { searchTerm: searchTerm },
        success: function(response) {
            $("#searchResults").html(response); // Update search results container
        }
    });
}
</script>

</body>
</html>



