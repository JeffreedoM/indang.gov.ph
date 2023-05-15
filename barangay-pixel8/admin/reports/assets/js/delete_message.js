function confirmDelete() {
    if (confirm("Are you sure you want to delete this item?")) {
        // Send an AJAX request to the server to delete the item
        // If the delete operation was successful, display an alert message
        // Otherwise, display an error message
        $.ajax({
            url: 'delete.php',
            type: 'post',
            data: {
                id: 1
            },
            success: function(result) {
                alert("Item deleted successfully!");
            },
            error: function(xhr, status, error) {
                alert("Error deleting item: " + error);
            }
        });
    }
}