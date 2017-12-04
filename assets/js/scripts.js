$("button").click(function() {
     var product_id = $(this).data("id");
     var product_name = $(this).data("name");
     var product_price = $(this).data("price");
    
     $("#product_id").val(product_id);
     $("#product_name").text(product_name);
     $("#product_price").text("prijs: " + product_price + " euro");
});
