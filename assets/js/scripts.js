$("button").click(function() {
     var product_id = $(this).data("id");
     var product_name = $(this).data("name");
     var product_price = $(this).data("price");
    
     $("#product_id").val(product_id);
     $("#product_name").text(product_name);
     $("#product_price").text("prijs: " + product_price + " euro");
});

//dataTable
$("#example").dataTable({
    "columns": [
    { "width": "10%" },
    null,
    null,
    null,
    null,
    null
  ],
    responsive: true,
    aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
    ]
});

$("#example1").dataTable({
    responsive: true,
    aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
    ]
});

$("#example2").dataTable({
    "columns": [
    { "width": "10%" },
    null,
    null,
    null,
    { "width": "10%" }
  ],
    responsive: true,
    aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
    ]
});
