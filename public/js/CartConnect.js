class CartConnect {
    constructor(){
        this.cartConnect = document.querySelector('#cart-connect-btn');
        this.cartRedirect = document.querySelector('#cart-redirect-btn');
        this.homeMessage = document.querySelector('#home-message');
        this.homeOk = document.querySelector('#home-ok-btn');
        

        // EVENEMENTS AU CLICK DE LA SOURIS
        // this.cartConnect.addEventListener("click", this.connect.bind(this));
        this.homeOk.addEventListener("click", this.redirect.bind(this));
    }

    redirect() {
        this.homeMessage.style.display = 'none';

    }
}
var cartConnect = new CartConnect;