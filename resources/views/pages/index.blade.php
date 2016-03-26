@extends('layouts.app')

@section('content')
    <div class="container" id="productsApp">
        <div class="row well">
            <form @submit.prevent="addProduct" v-if="! updating" class="form-inline">
                <div class="form-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Product Name"
                           v-model="product.name"
                           required
                    >
                </div>

                <div class="form-group">
                    <input type="number"
                           class="form-control"
                           placeholder="Quantity in stock"
                           v-model="product.quantity"
                           required
                    >
                </div>

                <div class="form-group">
                    <input type="number"
                           step="any"
                           class="form-control"
                           placeholder="Price"
                           v-model="product.price"
                           required
                    >
                </div>

                <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-plus"></i> Save
                </button>
            </form>
            <form @submit.prevent="updateProduct" v-if="updating" class="form-inline">
                <div class="form-group">
                    <input type="text"
                           class="form-control"
                           placeholder="Product Name"
                           v-model="product.name"
                           required
                    >
                </div>

                <div class="form-group">
                    <input type="number"
                           class="form-control"
                           placeholder="Quantity in stock"
                           v-model="product.quantity"
                           required
                    >
                </div>

                <div class="form-group">
                    <input type="number"
                           step="any"
                           class="form-control"
                           placeholder="Price"
                           v-model="product.price"
                           required
                    >
                </div>

                <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-plus"></i> Save
                </button>
                <button class="btn btn-default" @click='cancelUpdate()'>
                    <i class="glyphicon glyphicon-refresh"></i> Cancel
                </button>
            </form>
            <hr>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity in Stock</th>
                        <th>Price per Item</th>
                        <th>Datetime submitted</th>
                        <th>Total value number</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products">
                        <td>@{{ product.product.name }}</td>
                        <td>@{{ product.product.quantity }}</td>
                        <td>@{{ product.product.price | currency }}</td>
                        <td>@{{ product.product.date_added }}</td>
                        <td>@{{ product.product.price * product.product.quantity | currency }}</td>
                        <td>
                            <button class="btn btn-danger btn-xs" @click="removeProduct(product)">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            <button class="btn btn-primary btn-xs" @click="editProduct(product)">
                                <i class="glyphicon glyphicon-edit"></i>
                            </button>
                        </td>
                    <tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total:</b> @{{ total | currency }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            {{--Pagination button--}}
            <nav>
                <ul class="pager">
                    <li v-show="pagination.previous" class="previous">
                        <a @click="paginate('previous')" class="page-scroll" href="#"><< Previous</a>
                    </li>
                    <li v-show="pagination.next" class="next">
                        <a @click="paginate('next')" class="page-scroll" href="#">Next >></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
