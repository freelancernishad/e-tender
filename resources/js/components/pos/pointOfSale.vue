<template>
    <div>
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Dashboard
                    </li>
                </ol>
            </div>
            <div class="row mb-3">
                <!-- Area Chart -->
                <div class="col-xl-7 col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <input type="text" class="form-control" v-model="pos" v-on:change="posidchange"
                                ref="focusMe" @focus="magic_flag = false" id="pos" autofocus />
                            <label for="pos" class="btn btn-info" id="posbtn" v-on:click="scanpos">{{ postext }}</label>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="font-size: 12px">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th style="padding: 12px 38px">
                                                Qty
                                            </th>
                                            <th style="padding: 12px 50px">
                                                Unit
                                            </th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in cartProduct" :key="product.id">
                                            <td>{{ product.product_name }}</td>
                                            <td>
                                                <div
                                                    class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend">
                                                        <button @click.prevent="
                                                            decrement(
                                                                product.id
                                                            )
                                                        " class="btn btn-primary btn-sm bootstrap-touchspin-down"
                                                            type="button" v-if="
                                                                product.product_quantity >=
                                                                2
                                                            ">
                                                            -
                                                        </button>
                                                        <button @click.prevent="
                                                            decrement(
                                                                product.id
                                                            )
                                                        " class="btn btn-primary btn-sm bootstrap-touchspin-down"
                                                            type="button" v-else="" disabled="">
                                                            -
                                                        </button>
                                                    </span>
                                                    <input type="text" readonly class="form-control" :value="
                                                        product.product_quantity
                                                    " style="width: 28px" />
                                                    <span class="input-group-btn input-group-append">
                                                        <button @click.prevent="
                                                            increment(
                                                                product.id
                                                            )
                                                        " class="btn btn-primary btn-sm bootstrap-touchspin-up"
                                                            type="button">
                                                            +
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" v-model="
                                                    product.product_price
                                                " @change="
    priceChange(
        product.id,
        product.product_price
    )
" class="form-control" />
                                            </td>
                                            <td>{{ product.sub_total }}$</td>
                                            <td>
                                                <a @click="
                                                    deleteItem(product.id)
                                                " class="btn btn-sm btn-danger" style="color: white">X</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="order-md-2 mb-4">
                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Total Quantity</h6>
                                        </div>
                                        <span class="text-muted">{{
                                                qty
                                        }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Sub Total</h6>
                                        </div>
                                        <span class="text-muted">${{ sub_total }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">Vat</h6>
                                        </div>
                                        <span class="text-muted">{{ vats.vat }}%</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between bg-light">
                                        <div class="text-success">
                                            <h6 class="my-0">Total (USD)</h6>
                                        </div>
                                        <span class="text-success">${{
                                                (sub_total * vats.vat) / 100 +
                                                sub_total
                                        }}</span>
                                    </li>
                                </ul>
                                <form @submit.prevent="orderDone">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Select Customer</label>
                                        <select class="form-control" id="exampleFormControlSelect1"
                                            v-model="customer_id">
                                            <option v-for="customer in customers" :value="customer.id">
                                                {{ customer.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Pay</label>
                                        <input type="text" class="form-control" v-model="pay"
                                            id="exampleFormControlInput1" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput2">Due</label>
                                        <input type="text" class="form-control" v-model="due"
                                            id="exampleFormControlInput2" />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Pay By</label>
                                        <select class="form-control" id="exampleFormControlSelect2" v-model="payBy">
                                            <option value="Cheque">
                                                Cheque
                                            </option>
                                            <option value="Hand Cash">
                                                Hand Cash
                                            </option>
                                            <option value="Gift Card">
                                                Gift Card
                                            </option>
                                        </select>
                                    </div>
                                    <button class="btn btn-success" type="submit">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pie Chart -->
                <div class="col-xl-5 col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 class="m-0 font-weight-bold text-primary">
                                Products
                            </h5>
                            <input type="text" placeholder="Search" v-model="searchTerm" v-on:input="searchData" class="form-control"
                                style="width: 300px" />
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true"  @click="allProduct()" >Home</a>
                            </li>
                            <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false"
                                    @click="categoryProduct(category.id)">{{ category.category_name }}</a>
                            </li>
                        </ul>



                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6" v-for="product in products.data"
                                            :key="product.id">
                                            <div class="card" style="
                                                    align-items: center;
                                                    margin-bottom: 10px;
                                                ">
                                                <button class="btn btn-sm" @click.prevent="
                                                    addToCart(product.id)
                                                ">
                                                    <img :src="product.image" class="card-img-top" id="image_size"
                                                        alt="..." />
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center">
                                                            {{
                                                                    product.product_name
                                                            }}
                                                            -
                                                            {{
                                                                    product.selling_price
                                                            }}$
                                                        </h5>
                                                        <td v-if="
                                                            product.product_quantity >=
                                                            1
                                                        ">
                                                            <span class="badge badge-success">Available
                                                                <span class="badge badge-light">{{
                                                                        product.product_quantity
                                                                }}</span></span>
                                                        </td>
                                                        <td v-else="">
                                                            <span class="badge badge-danger">Stock Out</span>
                                                        </td>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <pagination :data="allitems" v-bind:showDisabled="true" icon="chevron"
                        v-on:change-page="allProduct"></pagination>
                </div>
            </div>
            <!--Row-->
        </div>
    </div>
</template>
<script>
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "/" });
        }
    },
    mounted() {
        this.allProduct();
        this.allCategory();
        this.allCustomers();
        this.cartProducts();
        this.vat();
        Reload.$on("afterAddToCart", () => {
            this.cartProducts();
        });
    },
    data() {
        return {
            products: [],
            allitems: {},
            qt: null,
            orqt: null,
            categories: [],
            categoryProducts: [],
            customers: [],
            cartProduct: [],
            searchTerm: "",
            vats: "",
            // Form
            customer_id: "",
            pay: "",
            due: "",
            payBy: "",
            pos: "",
            magic_flag: false,
            postext: "Scan",
            isActive: false,
            cat_id :'',
        };
    },
    computed: {
        filtersearch() {
            return this.products.filter((product) => {
                return product.product_name.match(this.searchTerm);
            });
        },
        filterCatSearch() {
            return this.categoryProducts.filter((catProduct) => {
                return catProduct.product_name.match(this.searchTerm);
            });
        },
        qty() {
            let sum = 0;
            for (let i = 0; i < this.cartProduct.length; i++) {
                sum += parseFloat(this.cartProduct[i].product_quantity);
            }
            return sum;
        },
        sub_total() {
            let sum = 0;
            for (let i = 0; i < this.cartProduct.length; i++) {
                sum += parseFloat(this.cartProduct[i].sub_total);
            }
            return sum;
        },
    },
    methods: {
        allProduct(page) {
            if (typeof page === "undefined") {
                page = 1;
            }

            var s_url = '';
            if(this.searchTerm==''){
                s_url = "/api/product?page=" + page;
            }else{
                s_url = '/api/products/search?filter[product_name]=' + this.searchTerm;

            }

            axios
                .get(s_url)
                .then(({ data }) => {
                    this.products = data;
                    this.allitems = data;
                    this.qt = data.data[0].product_quantity;
                    // console.log(data);
                })
                .catch();
        },



		searchData(page){

            var s_url = '';
            if(this.cat_id==''){
                s_url = '/api/products/search?filter[product_name]=' + this.searchTerm;
            }else{
                s_url = '/api/products/search?filter[product_name]=' + this.searchTerm+'&filter[category_id]='+this.cat_id;

            }

            // clear timeout variable
            clearTimeout(this.timeout);

            this.timeout = setTimeout( ()=> {


                if (typeof page === 'undefined') {
                     page = 1;
                 }
                 axios.get(s_url)
                 .then(({data}) => {

                     this.products = data
                     this.allitems = data
                     //  console.log(this.products)
                 })
                 .catch()

            }, 300);


		},

        allCategory() {
            axios
                .get("/api/category")
                .then(({ data }) => {
                    this.categories = data;
                })
                .catch();
        },
        categoryProduct(id) {
            this.cat_id = id

            if(this.searchTerm==''){

            axios
                .get("/api/category/product/" + id)
                .then(({ data }) => {
                    //  this.categoryProducts = data
                    this.products = data;
                    this.allitems = data;
                    console.log(data);
                })
                .catch();
            }else{
                this.searchData();
            }



        },
        allCustomers() {
            axios
                .get("/api/customer")
                .then(({ data }) => (this.customers = data))
                .catch();
        },
        // Cart
        addToCart(id) {
            axios
                .get("/api/addToCart/" + id)
                // .then(({data}) => (console.log(data)))
                .then(({ data }) => {
                    //   console.log(data);
                    if (data == 0) {
                        Notification.Out_of_stock();
                        this.qt = data;
                        Reload.$emit("afterAddToCart");
                    } else {
                        this.qt = data;
                        Reload.$emit("afterAddToCart");
                        Notification.cart_success();
                    }
                    this.pos = "";
                })
                .catch();
        },
        posidchange() {
            if (this.pos != "") {
                axios
                    .get("/api/product_code/" + this.pos)
                    .then(({ data }) => {
                        //    console.log(data[0].id)
                        if (data == 0) {
                            Notification.not_found();
                            this.pos = "";
                        } else {
                            this.addToCart(data[0].id);
                            this.postext = "Scaning";
                        }
                    })
                    .catch(console.log("error"));
                this.$refs.focusMe.focus();
            }
        },
        scanpos() {
            this.magic_flag = true;
            this.postext = "Scaning";
            console.log(this.magic_flag);
            this.$refs.focusMe.focus();
        },
        cartProducts() {
            axios
                .get("/api/cart-products")
                .then(({ data }) => {
                    this.cartProduct = data;
                    //    this.qt = this.qt-this.qty
                    //     console.log(this.qty);
                    //  console.log(this.cartProduct);
                })
                .catch();
        },
        deleteItem(id) {
            axios
                .get("/api/cart/delete/" + id)
                .then(() => {
                    Reload.$emit("afterAddToCart");
                    Notification.cart_delete();
                })
                .catch();
        },
        increment(id) {
            // console.log(id);
            axios
                .get("/api/cart/increment/" + id)
                .then(({ data }) => {
                    // console.log(data);
                    if (data == 0) {
                        Notification.Out_of_stock();
                        this.qt = data;
                        Reload.$emit("afterAddToCart");
                    } else {
                        this.qt = data;
                        Reload.$emit("afterAddToCart");
                        Notification.success();
                    }
                })
                .catch();
        },
        decrement(id) {
            axios
                .get("/api/cart/decrement/" + id)
                .then(({ data }) => {
                    this.qt = data;
                    Reload.$emit("afterAddToCart");
                    Notification.success();
                    // Reload.$emit('afterAddToCart')
                    // Notification.success()
                })
                .catch();
        },
        priceChange(id, price) {
            // console.log(id,price)
            axios
                .get("/api/cart/price/" + id + "/" + price)
                .then(({ data }) => {
                    Reload.$emit("afterAddToCart");
                    Notification.success();
                    // Reload.$emit('afterAddToCart')
                    // Notification.success()
                })
                .catch();
        },
        vat() {
            axios
                .get("/api/vat")
                .then(({ data }) => (this.vats = data))
                .catch();
        },
        orderDone() {
            let total = (this.sub_total * this.vats.vat) / 100 + this.sub_total;
            var data = {
                qty: this.qty,
                sub_total: this.sub_total,
                customer_id: this.customer_id,
                pay: this.pay,
                due: this.due,
                payBy: this.payBy,
                vat: this.vats.vat,
                total: total,
            };
            axios.post("/api/order", data).then(({ data }) => {
                this.$router.push({
                    name: "orderDetails",
                    params: { id: data },
                });
                Notification.success();
            });
        },
    },
};
</script>
<style lang="css" scoped>
#image_size {
    height: 100px;
    width: 135px;
}
</style>
