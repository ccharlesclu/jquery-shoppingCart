<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>eCommerce Test</title>

<link rel="stylesheet" type="text/css" href="style.css" />
</head>
    
<body>
	<div id="page">
		<div id="cart"><a href="#">cart (<span id="cart-total">cartCount</span>)</a></div>

		<h1>Cart Test</h1>

		<div class="product prod-01">
			<div class="product-image"></div>
			<form onSubmit="addItemToCart();">
				<select class="prod-quantity selQty" name="prodQuantity"></select>
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


		<div class="result-prodID"><span></span></div>
		<div class="result-prodQuantity"><span></span></div>

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
                    +"<input class='prod-input' type='number' data-name='"+cart[i].id+"'value='"+cart[i].qty+"'>"
                    +"<input type='submit' value='update'>" //for submit button use FORM to get relationship (shouldn't need form action because we're using JS -- maybe need get?  probably not)
                    +"<a class='delete-prod' onclick='removeFromCart("+cart[i].id+")'>X</a>"
                    +"</li>"
            }
            $("#cart-view").html(output);
        }
        
        var cart = [];
        var cartCount = 0;
        
        var Item = function(id, qty){
            this.id = id
            this.qty = qty
        };
        
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
            console.log(urlPrint);
        }
        
        function refresh(){
            refreshCart();
            printLink();
            displayCart();
            storeArray(cart);
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
        
		var cooktest = Cookies.get('dara');
		var prodcount = Cookies.get('prodcount'); //don't think we need this now
		var carturl = Cookies.get('cartpath'); //switch to new URL
		if (cooktest != "" && cooktest != null) {
			$('#cart a').attr( 'href', carturl );
			//$('#cart-total').text( prodcount );
            refreshCart();
		}

		var tProdID = Cookies.get('testProdID'); //was for testing
		var tProdQty = Cookies.get('testProdQty'); //was for testing
		$('.result-prodID').text( tProdID ); //was for testing
		$('.result-prodQuantity').text( tProdQty ); //was for testing
	})

	$(function(){
		var $selectMax = 25;
		var $select = $(".selQty");
		for (i=1;i<=$selectMax;i++){
			$select.append($('<option></option>').val(i).html(i))
		}
	});
    
    $("#cart-view").on("change", ".prod-input", function(event){
        var name = $(this).attr("data-name");
        var count = Number($(this).val());
        console.log("Cart changed: "+name+", "+count);
        setCountForItem(name, count);
    });
    
    $('.submit-addToCart').click(function() {        
        var selQty = $('.selQty').val();
        addItemToCart($(this).attr('href'), parseInt(selQty));
        refresh();
        
        return false;
	});
    
    $('.btn-removeFromCart').click(function(){
        removeFromCart($(this).attr('href'));
        refresh();

		return false;
    });

	$('.btn-addToCart').click(function() {
        addItemToCart($(this).attr('href'), 1);
        refresh();
                              
		return false;
	});

	$('#clearcook').click(function() { 
        cart = [];
        Cookies.remove('cartCookie');
        refresh();
        console.log(cart)
        urlPrint = ''
        
		return false;
	})
    
</script>
</body>
</html>
