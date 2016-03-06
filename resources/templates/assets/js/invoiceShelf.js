function roundNumber(number, decimal_points) {
            if (!decimal_points) return Math.round(number);
            if (number == 0) {
                var decimals = "";
                for (var i = 0; i < decimal_points; i++) decimals += "0";
                return "0." + decimals;
            }

            var exponent = Math.pow(10, decimal_points);
            var num = Math.round((number * exponent)).toString();
            return num.slice(0, -1 * decimal_points) + "." + num.slice(-1 * decimal_points)
        }
// Show the selected logo image
function logoImg(input) {
  if (input.files && input.files[0]) {
  var reader = new FileReader();

  reader.onload = function (e) {
    $('#img_prev')
    .attr('src', e.target.result);
  };

  reader.readAsDataURL(input.files[0]);
}
$('.delete-logo').css('display', 'inline-block');
}
    
// Update total invoice amount
function update_total() {
  var total = 0;
  var taxrate = $('#invoice_taxrate').val();
  var totalamount = 0;
  
  $('.price').each(function(i){
    price = $(this).html().replace("$","");
    if (!isNaN(price)) total += Number(price);
  });
  
  subtotal = roundNumber(total,2);
  taxtotal = roundNumber(subtotal * taxrate - subtotal,2);
  total = roundNumber(subtotal * taxrate,2);
  
  $('#subtotal').html(subtotal);
  $('#taxtotal').html(taxtotal);
  $('#invoice_total_tax').val(taxtotal);
  $('#total').html(total);
  
  update_balance();
}

// Update total balance
function update_balance() {
  var due = $("#total").html().replace("$","") - $("#paid").val().replace("$","");
  due = roundNumber(due,2);
  
  $('.due').html(due);
}

// Update prices
function update_price() {
  var row = $(this).parents('.item-row');
  var price = row.find('.cost').val().replace("$","") * row.find('.qty').val();
  price = roundNumber(price,2);
  isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html(price);
  
  update_total();
}

function bind() {
  $(".cost").blur(update_price);
  $(".qty").blur(update_price);

}

$(document).ready(function() {




    
  // Activate the bootstrap datepicker
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true
  })
  
  // Delete the invoice logo 
  $( "#delete-logo" ).click(function() {
    $('#img_prev').attr('src', 'assets/img/logo-placeholder.png'); // change to your default logo src 
    $('.select-logo').val('');
    $('#delete-logo').css('display', 'none');
  });
  
  // Activate validation for all file inputs
  $.validate({
    modules : 'file'
  });

  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
    $("#invoice_taxrate").change(update_total);
  
  // Add new items row to invoice
  // If you like to change your HTML for your invoice item, do so below, make sure you keep the right classes
  $("#addrow").click(function(){
    $(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><input type="text" class="form-control item-name" placeholder="Item name" name="item_name[]" value=""><a class="delete btn" href="javascript:;" title="Remove row"><span class="glyphicon glyphicon-remove-circle" style="color:#cccccc;"></span></a></div></td><td class="description"><textarea class="form-control" name="item_description[]" rows="1" placeholder="Item description" id="itemDescription"></textarea></td><td><input type="text" class="cost form-control" name="item_price[]" id="itemPrice" placeholder="0.00"></td><td><input type="text" class="qty form-control" value="" name="item_qty[]" placeholder="0" id="itemQty"></td><td align="right"><span class="price">$0.00</span></td></tr>');
    if ($(".delete").length > 0) $(".delete").show();
    bind();
    $(".item-row:last").find(".item-name").autocomplete({
                source: function( request, response ) {
                $.ajax({
                    url: "ajaxItems.php",
                    dataType: "json",
                    data: {term: request.term},
                    success: function(data) {
                                response($.map(data, function(item) {
                                return {
                                    label: item.articleName,
                                    description: item.articleDescription,
                                    price: item.articlePrice
                                   
                                    };
                            }));
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                        var $itemrow = $(this).closest('tr');

                       $itemrow.find('#itemPrice').val(ui.item.price);
                       
                       $itemrow.find("#itemDescription").val(ui.item.description);
                       $itemrow.find("#itemQty").focus();
                }
            });
    $(".item-name").focus();
  });
  
  bind();
  
  $(document).on("click","a.delete", function() {
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 2) $(".delete").hide();
  });

$(".item-name").autocomplete({
                source: function( request, response ) {  // 'request' is an object wherease 'response' is a function with an object passed as a parameter 
                $.ajax({
                    url: "ajaxItems.php",
                    dataType: "json",
                    data: {
                      term: request.term
                    },
                    success: function(data) {
                                response($.map(data, function(item) { // here we have translated the object into the 'data' object, therefore we have an object as a param
                                return {
                                    label: item.articleName,
                                    description: item.articleDescription,
                                    price: item.articlePrice
                                   
                                    };
                            }));
                        }
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                       $('#itemPrice').val(ui.item.price);
                       $("#itemQty").focus();
                       $("#itemDescription").val(ui.item.description);
                }
            });

});