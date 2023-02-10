<template>
	<div class="row justify-content-center">
		<div class="col-xl-12 col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-12 mb-4">
					<!-- Simple Tables -->
					<div class="card">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

							<h2 class="m-0 font-weight-bold text-primary">Product List</h2>

							<input type="text" placeholder="Search By Product Name" v-model="searchTerm" v-on:input="searchData" class="form-control" style="width: 300px;">
		<router-link to="/store-product" class="btn btn-primary float-right" style="margin-top: 6px;margin-right: 6px;">Add Product</router-link>
						</div>
                        <!-- <qr-code text="Text to encode"></qr-code>

  <input v-model="barcodeValue" /><br>
  <barcode v-bind:value="barcodeValue">
    Show this if the rendering fails.
  </barcode> -->

						<div class="table-responsive">
							<table class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th>Product Name</th>
										<th>Image</th>
										<th>Barcode</th>
										<th>Product Code</th>
										<th>Category</th>
										<th>Supplier</th>
										<th>Root</th>
										<th>Buying Price</th>
										<th>Selling Price</th>
										<th>Product Quantity</th>
										<th>Buying Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>


<!-- v-for="lang in paginated('languages')" -->

									<tr v-for="product in products.data" :key="product.id">
										<td>{{ product.product_name }}</td>
										<td><img :src="product.image" id="img_size"></td>
										<td>

                                            <!-- <b-button @click="barcodesownload(product.product_code)">Open Modal</b-button> -->

                                            <barcode style="width: 10px;
    height: 10px;display:none" :id="product.id" :value="product.product_code">Show this if the rendering fails.</barcode>




     <b-button color="green darken-1" style=""  @click="print(product.id)">Download</b-button>



                                            </td>
										<td>{{ product.product_code }}</td>
										<td>{{ product.category_name }}</td>
										<td>{{ product.name }}</td>
										<td>{{ product.root }}</td>
										<td>{{ product.buying_price }}</td>
										<td>{{ product.selling_price }}</td>
										<td>{{ product.product_quantity }}</td>
										<td>{{ product.buying_date }}</td>
										<td>
											<router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-sm btn-primary">Edit</router-link>
											<a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger" style="color: white">Delete</a>
										</td>
									</tr>



								</tbody>
							</table>





<!-- <Pagination :data="products" @pagination-change-page="filtersearch" /> -->

						</div>
						<div class="card-footer">

<pagination :data="allitems" v-bind:showDisabled="true" icon="chevron" v-on:change-page="allProduct"></pagination>

                        </div>
					</div>
				</div>
			</div>
		</div>
<!--
<paginate
  name="languages"
  :list="langs"
  :per="2"
>
  <li v-for="lang in paginated('languages')">
    {{ lang }}
  </li>
</paginate> -->


    <!-- <b-modal  v-model="modalShow"><barcode id="print" :value="barcodeid">Show this if the rendering fails.</barcode>

     <b-button color="green darken-1"  @click="print()">Print</b-button>
    </b-modal> -->

	</div>
</template>

<script>
export default {

	created(){
		if (!User.loggedIn()) {
			this.$router.push({name: '/'})
		}
	},

	data () {
		return {
			products: [],
			allitems: {},
			searchTerm:"",
            barcodeValue: 'test',
            modalShow: false,
            barcodeid: '',
             timeout: null

		}
	},
	computed: {
		filtersearch(){
			return this.products.filter(product => {
                // console.log(product)
				return product.product_name.match(this.searchTerm)
			})
		}
	},
	methods: {

    print(id) {
      var prtContent = document.getElementById(id);
      var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
      WinPrint.document.write(prtContent.innerHTML);
      WinPrint.document.close();
      WinPrint.focus();
      WinPrint.print();
    //   WinPrint.close();
    },

        barcodesownload(id){
           this.barcodeid = id
             this.modalShow = true
        },
		allProduct(page){
           if (typeof page === 'undefined') {
				page = 1;
			}
			axios.get('/api/product?page=' + page)
			.then(({data}) => {

                this.products = data
                this.allitems = data
                //   console.log(data)
            })
			.catch()
		},

		searchData(page){


            // clear timeout variable
            clearTimeout(this.timeout);

            this.timeout = setTimeout( ()=> {


                if (typeof page === 'undefined') {
                     page = 1;
                 }
                 axios.get('/api/products/search?filter[product_name]=' + this.searchTerm)
                 .then(({data}) => {

                     this.products = data
                     this.allitems = data
                     //  console.log(this.products)
                 })
                 .catch()

            }, 300);


		},




		deleteProduct(id){
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.isConfirmed) {
					axios.delete('/api/product/' + id)
						 .then(() => {
						 	this.products = this.products.filter(product => {
						 		return product.id != id
						 	})
						 })
						 .catch(() => {
						 	this.$router.push({name: 'product'})
						 })

					Swal.fire(
						'Deleted!',
						'Your file has been deleted.',
						'success'
						)
				}
			})
		}
	},
	mounted(){
		this.allProduct();
	}
}
</script>

<style lang="css" scoped>
#img_size{
	width: 40px;
}



</style>
