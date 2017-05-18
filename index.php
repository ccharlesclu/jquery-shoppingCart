<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>eCommerce Test</title>

<link rel="stylesheet" type="text/css" href="style.css" />
</head>
    
<body>
	<div id="page">
		<div id="cart"><a href="#">cart (<span id="cart-total">0</span>)</a></div>

		<h1>Cart Test</h1>

		<div class="product prod-01">
			<div class="product-image"></div>
			<form onSubmit="addItemToCart();">
				<select class="prod-quantity selQty" name="prodQuantity"></select>
				<input type="submit" class ="submit-addToCart" value="Add to Cart" href="106100">
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
			<li class="cart-product">
			    <a class="delete-prod" onclick="removeFromCart()">X</a>
			    <img id="prod-id-" src="domain/directory/imageName">
			    <span class="prod-name">Bottle o stuff</span>
			    <input class="prod-quantity" type="number" value="4">
			    <input type="submit" value="update">
			</li>
		    </ul>
		</section>
	</div> <!-- #page -->
        
    <script>
        var cart = [];
        var Item = function(id, qty){
            this.id = id
            this.qty = qty
        };
        
        function addItemToCart(id, qty){
            for(var i in cart){
                if(cart[i].id == id){
                    cart[i].qty += qty;
                    return;
                }
            }
            var item = new Item(id, qty);
            cart.push(item);
        }
        
        function removeFromCart(id){
            for(var i in cart){
                if(cart[i].id == id){
                    cart[i].qty --;
                    if(cart[i].qty === 0){
                        cart.splice(i, 1);
                    }
                    break;
                }
            }
        }
        
        var urlPrint = '';
        
        function printLink(itemRef){
            var urlProduct = '';
            var urlpart0 = 'https://extranet.securefreedom.com/GHTHealth/Order/shop.asp?itemCount=';
            var urlpartreturn = '&ReturnURL=http://vibrantnutra.com/vibrantshop.aspx';
            var urlpartsignup = '&SignupType=';
            var urlpartrep = '';
            for(var i in cart){
                var urlItem = '&item' + i + '=' + itemRef + '&qnt' + i + '=' + cart[i].qty;
                urlProduct += urlItem;
            }
            urlPrint = urlpart0 + urlProduct + urlpartreturn + urlpartsignup + urlpartrep;
            console.log(urlPrint);
        }
        
        function cartCount(){
            var cartQty = 0;
            for(var i in cart){
                cartQty += cart[i].qty;
            }
            $('#cart-total').text( cartQty );
        }

    </script>

<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/js.cookie.js"></script>

<script type="text/javascript">
    
	$(document).ready(function() {
		var cooktest = Cookies.get('dara');
		var prodcount = Cookies.get('prodcount');
		var carturl = Cookies.get('cartpath');
		if (cooktest != "" && cooktest != null) {
			$('#cart a').attr( 'href', carturl );
			//$('#cart-total').text( prodcount );
            cartCount();
		}

		var tProdID = Cookies.get('testProdID');
		var tProdQty = Cookies.get('testProdQty');
		$('.result-prodID').text( tProdID );
		$('.result-prodQuantity').text( tProdQty );
	})

	$(function(){
		var $selectMax = 25;
		var $select = $(".selQty");
		for (i=1;i<=$selectMax;i++){
			$select.append($('<option></option>').val(i).html(i))
		}
	});
    
    $('.submit-addToCart').click(function() {        
        var selQty = $('.selQty').val();
        addItemToCart($(this).attr('href'), parseInt(selQty));
        cartCount();
        console.log(cart);
        
        return false;
	});
    
    $('.btn-removeFromCart').click(function(){
        removeFromCart($(this).attr('href'));
        console.log(cart);
        printLink($(this).attr('href'));
        cartCount();
        
        var urlpart0 = 'https://extranet.securefreedom.com/GHTHealth/Order/shop.asp?itemCount=';
		var urlpartreturn = '&ReturnURL=http://vibrantnutra.com/vibrantshop.aspx';
		var urlpartsignup = '&SignupType=';
		var urlpartrep = '';

		var repidtest = Cookies.get(itemnum);
//		var urlpartrep = '&RepID=' + repidtest;
		if (repidtest == "" || repidtest == null || repidtest == "0") {
			var urlpartrep = '&RepID=106860';
		} else {
			var urlpartrep = '&RepID=' + repidtest;
		}

		var cooktest = Cookies.get('dara');
		if (cooktest == "" || cooktest == null) {
			// Set product count (variable and cookie) when first item is clicked
			var prodcount = 1;
            Cookies.set('prodcount', prodcount, { expires: 1/48 } );

			// Get href value from clicked anchor tag, build product info, and set cookie
			var darhref = $(this).attr('href');
			var itemnum = prodcount - 1;
			var prodval = '&item' + itemnum + '=' + darhref + '&qnt' + itemnum + '=1';
			Cookies.set('dara', prodval, { expires: 1/48 } );

			// Return cookie value, build url and update cart link
			var cartlink = Cookies.get('dara');
			var carturl = urlpart0 + prodcount + cartlink + urlpartreturn + urlpartsignup + urlpartrep;
			Cookies.set('cartpath', carturl, { expires: 1/48 } );
			$('#cart a').attr( 'href', carturl );

			// Update product count in cart link text
			//$('#cart-total').text( prodcount );
		} else {
			// Update product count (variable and cookie) each time an item is clicked
			var prodcount = parseInt(Cookies.get('prodcount'));
			prodcount++;
			Cookies.set('prodcount', prodcount, { expires: 1/48 } );

			// Get href value from clicked anchor tag, update cookie and cart link
			var darhref = $(this).attr('href');
			var itemnum = prodcount - 1;
			var prodval = '&item' + itemnum + '=' + darhref + '&qnt' + itemnum + '=1';
			var cartlink = Cookies.get('dara');
			var cartlinknew = cartlink + prodval;
			Cookies.set('dara', cartlinknew, { expires: 1/48 } );
			var carturl = urlpart0 + prodcount + cartlinknew + urlpartreturn + urlpartsignup + urlpartrep;
			Cookies.set('cartpath', carturl, { expires: 1/48 } );
			$('#cart a').attr( 'href', carturl );

			// Update product count in cart link text
			//$('#cart-total').text( cartQty );
		}
		return false;
    })

	$('.btn-addToCart').click(function() {
        
        // CHRIS
        addItemToCart($(this).attr('href'), 1);
        console.log(cart);
        printLink($(this).attr('href'));
        cartCount();
        
        var urlpart0 = 'https://extranet.securefreedom.com/GHTHealth/Order/shop.asp?itemCount=';
		var urlpartreturn = '&ReturnURL=http://vibrantnutra.com/vibrantshop.aspx';
		var urlpartsignup = '&SignupType=';
		var urlpartrep = '';

		var repidtest = Cookies.get(itemnum);
//		var urlpartrep = '&RepID=' + repidtest;
		if (repidtest == "" || repidtest == null || repidtest == "0") {
			var urlpartrep = '&RepID=106860';
		} else {
			var urlpartrep = '&RepID=' + repidtest;
		}

		var cooktest = Cookies.get('dara');
		if (cooktest == "" || cooktest == null) {
			// Set product count (variable and cookie) when first item is clicked
			var prodcount = 1;
            Cookies.set('prodcount', prodcount, { expires: 1/48 } );

			// Get href value from clicked anchor tag, build product info, and set cookie
			var darhref = $(this).attr('href');
			var itemnum = prodcount - 1;
			var prodval = '&item' + itemnum + '=' + darhref + '&qnt' + itemnum + '=1';
			Cookies.set('dara', prodval, { expires: 1/48 } );

			// Return cookie value, build url and update cart link
			var cartlink = Cookies.get('dara');
			var carturl = urlpart0 + prodcount + cartlink + urlpartreturn + urlpartsignup + urlpartrep;
			Cookies.set('cartpath', carturl, { expires: 1/48 } );
			$('#cart a').attr( 'href', carturl );

			// Update product count in cart link text
			//$('#cart-total').text( prodcount );
		} else {
			// Update product count (variable and cookie) each time an item is clicked
			var prodcount = parseInt(Cookies.get('prodcount'));
			prodcount++;
			Cookies.set('prodcount', prodcount, { expires: 1/48 } );

			// Get href value from clicked anchor tag, update cookie and cart link
			var darhref = $(this).attr('href');
			var itemnum = prodcount - 1;
			var prodval = '&item' + itemnum + '=' + darhref + '&qnt' + itemnum + '=1';
			var cartlink = Cookies.get('dara');
			var cartlinknew = cartlink + prodval;
			Cookies.set('dara', cartlinknew, { expires: 1/48 } );
			var carturl = urlpart0 + prodcount + cartlinknew + urlpartreturn + urlpartsignup + urlpartrep;
			Cookies.set('cartpath', carturl, { expires: 1/48 } );
			$('#cart a').attr( 'href', carturl );

			// Update product count in cart link text
			//$('#cart-total').text( cartQty );
            
            //console.log(prodval);
		}
		return false;
	})

	function bake_cookie(name, value) {
		var cookie = [name, '=', JSON.stringify(value), '; domain=.', window.location.host.toString(), '; path=/;'].join('');
		document.cookie = cookie;
	}

	function read_cookie(name) {
		var result = document.cookie.match(new RegExp(name + '=([^;]+)'));
		result && (result = JSON.parse(result[1]));
		return result;
	}    

	$('#clearcook').click(function() {
                
        cart = [];
        console.log(cart)
        cartQty = 0;
        urlPrint = '';
        
		// Clear cookies and reset cart link and count
		Cookies.remove('dara');
		Cookies.remove('tProdID');
		Cookies.remove('tProdQty');
		$('#cart a').attr( 'href', '#' );
		$('#cart-total').text( '0' );
		$('.result-prodID').text( '0' );
		$('.result-prodQuantity').text( '0' );
		return false;
	})
</script>
</body>
</html>
