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
			<h1 class="entry-title-106100">Active Systemic Enzymes</h1>
			<div class="product-image-106100"><img src="http://www.vibrantnutra.com/wp-content/uploads/2016/06/ActiveSystemicEnzymes_60caps_1703.png" class="wp-post-image" ></div>
			<form onSubmit="addItemToCart();">
				<label class="dgo-product-price-106100"><span><sup>$</sup>27.00</span></label>
				<select class="prod-quantity selQty"></select>
				<input type="submit" class="submit-addToCart" value="Add to Cart" href="106100">
			</form>
		</div> <!-- .product -->

		<div class="product prod-02">
			<h1 class="entry-title-105100">Clarifiber</h1>
			<div class="product-image-105100"><img src="http://www.vibrantnutra.com/wp-content/uploads/2016/06/Clarifiber_1703.png" class="wp-post-image"></div>
			<div class="dgo-product-price-105100"><span><sup>$</sup>22.50</span></div>
			<a class="btn-addToCart" href="105100">Add to cart</a>
		</div> <!-- .product -->

		<div class="product prod-03">
			<h1 class="entry-title-104150">KidsLac</h1>
			<div class="product-image-104150"><img src="http://www.vibrantnutra.com/wp-content/uploads/2016/06/KidsLac_SourApple_front_1703.png" class="wp-post-image"></div>
			<div class="dgo-product-price-104150"><span><sup>$</sup>19.95</span></div>
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
                    +"<img id='prod-id-' src='"+cart[i].img+"' style='max-width:25px; max-height:50px;'>"
                    //+"<span class='prod-id prod-id-"+cart[i].id+"'>"+cart[i].id+"</span>"
                    +"<span class='prod-name prod-name-"+cart[i].name+"'>"+cart[i].name+"</span>"
                    +"<select class='prod-quantity qtySelect' id='"+cart[i].id+"' data-name='"+cart[i].id+"'/>"
                    +"<span class='prod-total prod-total-"+cart[i].id+"'>@ $"+cart[i].price+" <span class='sym-eq'>=</span>                     $"+parseFloat(cart[i].price*cart[i].qty).toFixed(2)+"</span>"
                    +"<a class='delete-prod' onclick='removeFromCart("+cart[i].id+")'>Delete</a>"
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
        
        var Item = function(id, name, qty, img, price){
            this.id = id
            this.name = name
            this.qty = qty
            this.img = img
            this.price = price
        };
        
        var cart = [];
        var cartCount = 0;
        
        function addItemToCart(id, name, qty, img, price){
            for(var i in cart){
                if (cart[i].id == id) {
                    cart[i].qty += qty;
                    return;
                }
            }
            var item = new Item(id, name, qty, img, price);
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
            // console.log(urlPrint);
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
        var prod_name = $('.entry-title-'+$(this).attr('href')).text();
        var img_src  = $( '.product-image-'+$(this).attr('href')+' > img' ).attr( 'src' );
        var prod_price  = parseFloat($( '.dgo-product-price-'+$(this).attr('href')).text().replace("$","")).toFixed(2);
        addItemToCart($(this).attr('href'), prod_name, parseInt(selQty), img_src, prod_price);
        refresh();
        
            return false;
        });
    
    $('.btn-addToCart').click(function() {
        var prod_name = $('.entry-title-'+$(this).attr('href')).text();
        var img_src  = $( '.product-image-'+$(this).attr('href')+' > img' ).attr( 'src' );
        var prod_price  = parseFloat($( '.dgo-product-price-'+$(this).attr('href')).text().replace("$","")).toFixed(2);
        addItemToCart($(this).attr('href'), prod_name, 1, img_src, prod_price);
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
