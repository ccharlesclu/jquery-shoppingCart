<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>eCommerce Test</title>

<link rel="stylesheet" type="text/css" href="style.css" />
</head>
    
<body>
	<div id="page">
		<div id="cart"><a id="cart-ref" href="#">cart (<span id="cart-total">cartCount</span>)</a></div>

		<h1>Cart Test</h1>

		<div class="product prod-01">
			<div class="product-image"></div>
			<form onSubmit="addItemToCart();">
				<select class="prod-quantity selQty"></select>
				<input type="submit" class="submit-addToCart" value="Add to Cart" href="106100">
			</form>
		</div> <!-- .product -->

		<div class="product prod-02">
			<div class="product-image"></div>
			<a class="btn-addToCart" href="105100"0>Add to cart</a>
            <a class="btn-removeFromCart" href="105100"0>Remove from cart</a>
		</div> <!-- .product -->

		<div class="product prod-03">
			<div class="product-image"></div>
			<a class="btn-addToCart" href="104150">Add to cart</a>
		</div> <!-- .product -->

		<a id="clearcook" href="#">clear cookie</a>

		<section id="cart-view">
		    <ul>
		    </ul>
		</section>
        
	</div> <!-- #page -->
        
    <script>
        function displayCart(){
            var output = "";
            for(var i in cart){
                //need to do update button - either all in one (prod-name-id to array) or by line
                //innerHTML to get return
                output += "<li>"
                    +"<img id='prod-id-' src='domain/directory/imageName'>"
                    +"<span class='prod-name prod-name-"+cart[i].id+"'>"+cart[i].id+"</span>"    
                    +"<select class='prod-quantity qtySelect' id='"+cart[i].id+"' data-name='"+cart[i].id+"'/>"
                    +"<a class='delete-prod' onclick='removeFromCart("+cart[i].id+")'>X</a>"
                    +"</li>"
            }
            $("#cart-view").html(output);
            
            for(var i in cart) {
                var $selectMax = 25;
                var $select2 = $("#"+cart[i].id);
                var set = cart[i].qty;
                for(j=1; j<$selectMax; j++){
                    $select2.append($('<option></option>').val(j).html(j));
                }
                $select2.val(cart[i].qty);
            }
        }
        
        var Item = function(id, qty){
            this.id = id
            this.qty = qty
        };
        
        var cart = [];
        var cartCount = 0;
        
        function addItemToCart(id, qty){
            for(var i in cart){
                if (cart[i].id == id) {
                    cart[i].qty += qty;
                    return;
                }
            }
            var item = new Item(id, qty);
            cart.push(item);
        }
        
        function removeFromCart(id){
            for(var i in cart){
                if (cart[i].id == id) {
                    cart[i].qty = 0;
                    if (cart[i].qty === 0) {
                        cart.splice(i, 1);
                    }
                    break;
                }
            }
            refresh();
        }
        
        function refreshCart(){
            var cartQty = 0;
            for(var i in cart){
                cartQty += cart[i].qty;
            }
            cartCount = Number(cartQty);
            $('#cart-total').text( cartCount );
        }

        var urlPrint = '';
        function printLink(){
            if (cart.length != 0){
                var urlProduct = '';
                var urlpart0 = 'https://extranet.securefreedom.com/GHTHealth/Order/shop.asp?itemCount=';
                var urlpartreturn = '&ReturnURL=http://vibrantnutra.com/vibrantshop.aspx';
                var urlpartsignup = '&SignupType=';
                var urlpartrep = '';
                for(var i in cart){
                    var urlItem = '&item' + i + '=' + cart[i].id + '&qnt' + i + '=' + cart[i].qty;
                    urlProduct += urlItem;
                }
                urlPrint = urlpart0 + urlProduct + urlpartreturn + urlpartsignup + urlpartrep;
            } else {
                urlPrint = '';
            }
            console.log(urlPrint);
            $('a#cart-ref').attr('href', urlPrint);
        }
        
        function refresh(){
            refreshCart();
            printLink();
            storeArray(cart);
            displayCart();
            console.log(cart);
        }
        
        function setCountForItem(id, qty){
            for(var i in cart){
                if(this.cart[i].id === id){
                    this.cart[i].qty = qty;
                }
            }
            refresh();
        }
        
        function storeArray(array){
            var cartString = JSON.stringify(array);
            Cookies.set('cartCookie', cartString);
        }
        
        function retrieveCookie(cookie){
            if (document.cookie.indexOf('cartCookie') > -1) {
                cartString = Cookies.get(cookie);
                cart = JSON.parse(cartString);
            } else {
                cart = [];   
            }
        }

    </script>

<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/js.cookie.js"></script>
<script type="text/javascript">
    
	$(document).ready(function() {
        retrieveCookie('cartCookie');
        refresh();
	})

	$(function(){
		var $selectMax = 100;
		var $select = $(".selQty");
        //var $select2 = $(".qtySelect");
		for (i=1;i<=$selectMax;i++){
			$select.append($('<option></option>').val(i).html(i));
            //$select2.append($('<option></option>').val(i).html(i));
		}
        //$select2.val('44');
	});
    
    $("#cart-view").on("change", ".prod-quantity", function(event){
        var name = $(this).attr("data-name");
        var count = Number($(this).val());
        if (count > 0) {
            setCountForItem(name, count);   
        } else {
            removeFromCart(name);
        }
    });
    
    $('.submit-addToCart').click(function() {        
        var selQty = $('.selQty').val();
        addItemToCart($(this).attr('href'), parseInt(selQty));
        refresh();
        
        return false;
	});
    
    $('.btn-addToCart').click(function() {
        addItemToCart($(this).attr('href'), 1);
        refresh();
                              
		return false;
	});
    
    $('.btn-removeFromCart').click(function(){
        removeFromCart($(this).attr('href'));
        refresh();

		return false;
    });

	$('#clearcook').click(function() { 
        cart = [];
        Cookies.remove('cartCookie');
        refresh();
        //console.log(cart)
        urlPrint = ''
        
		return false;
	});
    
    
    
</script>
</body>
</html>
