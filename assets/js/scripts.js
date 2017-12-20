$("button").click(function() {
     var id = $(this).data("id");
     var name = $(this).data("name");
     var product_price = $(this).data("price");
    
     $("#id").val(id);
     $("#name").text(name);
     $("#product_price").text("prijs: " + product_price + " euro");
});

//dataTable
$("#example1").dataTable({
    responsive: true,
    aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
    ]
});

