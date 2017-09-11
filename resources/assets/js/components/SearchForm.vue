<template>
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div v-if="errors.length" v-for="error of errors" class="alert alert-danger" role="alert">
					{{ error }}
				</div>
				<form action="#" @submit.prevent="searchProperty">
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="name">Name <span class="text-danger">*</span></label>
							<input v-model="property.name" class="form-control" type="text" name="name">
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 form-group">
							<label for="bedrooms">Bedrooms</label>
							<input v-model="property.bedrooms" class="form-control" type="text" name="bedrooms">
						</div>
						<div class="col-md-3 form-group">
							<label for="bathrooms">Bathrooms</label>
							<input v-model="property.bathrooms" class="form-control" type="text" name="bathrooms">
						</div>
						<div class="col-md-3 form-group">
							<label for="storeys">Storeys</label>
							<input v-model="property.storeys" class="form-control" type="text" name="storeys">
						</div>
						<div class="col-md-3 form-group">
							<label for="garages">Garages</label>
							<input v-model="property.garages" class="form-control" type="text" name="garages">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<label>Price min.</label>
							<input v-model="property.price_min" class="form-control" type="text" name="price_min">
						</div>
						<div class="col-md-6 form-group">
							<label>Price max.</label>
							<input v-model="property.price_max" class="form-control" type="text" name="price_max">
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<ul v-if="property && property.length && noResults == false" class="list-group">
					<li v-for="item of property" class="list-group-item">
						<p><strong>{{ item.name }}</strong></p>
						<ul>
							<li>Price: {{ item.price }}</li>
							<li>Bedrooms: {{ item.bedrooms }}</li>
							<li>Bathrooms: {{ item.bathrooms }}</li>
							<li>Storeys: {{ item.storeys }}</li>
							<li>Garages: {{ item.garages }}</li>
						</ul>
					</li>
				</ul>
				<h4 v-if="noResults" class="text-center">No results...</h4>
				<div v-if="loading" class="loader-spinner"></div>
			</div>
		</div>
	</div>
</template>

<style>
.loader-spinner {
	margin: 10px auto;
	width: 128px;
	height: 15px;
	background: url(/img/ajax-loader.gif) center center no-repeat;
}
</style>

<script>
import axios from 'axios';

export default {
	data() {
		return {
			property: [],
			errors: [],
			loading: false,
			noResults: false
		};
	},
	methods: {
		searchProperty: function() {
			var self = this;
			this.loading = true;
			let params = Object.assign({}, self.property);
			if (params.price_min >= params.price_max) {
				this.errors.push({'bad_price': 'Bad price range...'});
			} else {
				axios.post('/api/search', params)
					.then(response => {
						this.property = response.data;
						this.noResults = (response.data.length == 0);
						this.loading = false;
					})
					.catch(err => {
						console.log(err.response.data);
						this.errors = err.response.data;
						this.noResults = false;
						this.loading = false;
					});
			}
		}
	}
}
</script>