<template>
  <main class="my-8">
    <div class="container mx-auto px-6">
      <div class="mt-16">
        <h3 class="text-gray-600 text-2xl font-medium">Fashions</h3>
        <div
          class="
            grid
            gap-6
            grid-cols-1
            sm:grid-cols-2
            lg:grid-cols-3
            xl:grid-cols-4
            mt-6
          "
        >
          <Product
            @addToCart="addToCart($event)"
            v-for="product in products.data"
            :key="product.id"
            :product="product"
          ></Product>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
// @ is an alias to /src
import Product from "@/components/Product.vue";
import axios from "axios";

export default {
  name: "Home",
  components: {
    Product,
  },

  data() {
    return {
      products: {
        data: [],
      },
    };
  },

  created() {
    axios.get(this.$api + "/api/products").then((response) => {
      this.products = response.data;
    });
  },

  methods: {
    addToCart(product) {
      this.$root.addToCart(product);
    },
  },
};
</script>
