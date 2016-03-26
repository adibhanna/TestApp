// Twitter bootstrap expects jQuery to be global that's why
// we are including jQuery and assigning it to the window.
window.$ = window.jQuery = require('jquery')

require('bootstrap-sass');
var Vue = require('vue');
Vue.use(require('vue-resource'));
Vue.http.headers.common['X-CSRF-TOKEN'] = $("meta[name=token]").attr("value");

new Vue({
    el: "#productsApp",

    data: {
        product: {
            name: null,
            quantity: null,
            price: null,
        },

        total: 0,

        products: [], // list of all products.

        updating: false,

        tempProduct: null,

        pagination: {
            page: 1,
            previous: false,
            next: false
        },

        validation: {
            name: true,
            quantity: true,
            price: true
        }
    },

    ready() {
        this.$http({url: '/api/products', method: 'GET'}, {page: this.pagination.page}).then(function (response) {
            this.$set('products', response.data.data);

            this.pagination.previous = response.data.prev_page_url;
            this.pagination.next = response.data.next_page_url;
        }, function () {
            console.log('Something wrong happened while fetching the products.');
        });

        this.fetchTotal();
    },

    methods: {
        paginate(direction) {
            if (direction === 'previous') {
                --this.pagination.page;
            }
            else if (direction === 'next') {
                ++this.pagination.page;
            }
            this.$http({url: '/api/products?page='+this.pagination.page, method: 'GET'}).then(function (response) {
                this.$set('products', response.data.data);
                this.pagination.previous = response.data.prev_page_url;
                this.pagination.next = response.data.next_page_url;
            }, function (response) {
                console.log('Something wrong happened while fetching the products.');
            });
        },

        addProduct() {
            var product = {
                name: this.product.name,
                price: this.product.price,
                quantity: this.product.quantity,
            };

            this.$http.post('/api/products', product, function (response) {
                this.products.push(response);
                this.total += product.price * product.quantity;
                this.clearFields();
            }).catch(function () {
                console.log('Something wrong happened while adding the product.');
            });
        },

        fetchTotal() {
            this.$http({url: '/api/total', method: 'GET'}).then(function (response) {
                this.$set('total', response.data);
            }, function () {
                console.log('Something wrong happened while fetching the products.');
            });
        },

        editProduct(product) {
            this.$set('tempProduct', product);

            this.product.name = product.product.name;
            this.product.price = product.product.price;
            this.product.quantity = product.product.quantity;

            this.updating = true;

            this.products.$remove(product);
        },

        cancelUpdate() {
            this.products.push(this.tempProduct);
            this.clearFields();
            this.tempProduct = null;
            this.updating = false;
        },

        updateProduct() {
            this.removeProduct(this.tempProduct);
            this.addProduct();
            this.updating = false;
        },

        removeProduct(product) {
            this.$http({url: '/api/products/'+product.id, method: 'DELETE'}).then(function () {
                this.products.$remove(product);
                this.fetchTotal();
            }, function () {
                console.log('Something wrong happened while deleting the product.');
            });

        },

        clearFields() {
            this.product.name = null;
            this.product.price = null;
            this.product.quantity = null;
        },

    }
});
